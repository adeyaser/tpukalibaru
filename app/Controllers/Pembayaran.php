<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\TagihanKeluargaModel;

class Pembayaran extends BaseController
{
    protected $model;
    protected $tagihanModel;

    public function __construct()
    {
        $this->model = new PembayaranModel();
        $this->tagihanModel = new TagihanKeluargaModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pembayaran',
            'breadcrumb' => [['title' => 'Data Pembayaran', 'active' => true]],
            'pembayaran' => $this->model->getAllWithDetails(),
        ];
        return view('pembayaran/index', $data);
    }

    public function create($tagihanId)
    {
        $db = \Config\Database::connect();
        $tagihan = $db->table('tagihan_keluarga')
            ->select('tagihan_keluarga.*, jenazah.nama_lengkap as nama_jenazah,
                      keluarga_jenazah.nama_lengkap as nama_keluarga')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('keluarga_jenazah', 'keluarga_jenazah.id = tagihan_keluarga.keluarga_id')
            ->where('tagihan_keluarga.id', $tagihanId)
            ->get()
            ->getRowArray();

        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Tagihan tidak ditemukan');
        }

        if ($tagihan['status'] === 'lunas') {
            return redirect()->to("/tagihan/view/{$tagihanId}")->with('error', 'Tagihan sudah lunas');
        }

        $data = [
            'title' => 'Input Pembayaran',
            'breadcrumb' => [
                ['title' => 'Data Tagihan', 'url' => base_url('tagihan'), 'active' => false],
                ['title' => 'Pembayaran', 'active' => true],
            ],
            'tagihan' => $tagihan,
        ];
        return view('pembayaran/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $tagihanId = $data['tagihan_id'];
        
        $tagihan = $this->tagihanModel->find($tagihanId);
        if (!$tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Tagihan tidak ditemukan');
        }

        // Validate payment amount
        if ($data['nominal'] > $tagihan['sisa']) {
            return redirect()->back()->withInput()
                ->with('error', 'Nominal pembayaran melebihi sisa tagihan');
        }

        $data['no_pembayaran'] = $this->model->generateNoPembayaran();
        $data['tanggal_bayar'] = $data['tanggal_bayar'] ?? date('Y-m-d H:i:s');
        $data['user_id'] = session()->get('userId');

        // Handle bukti upload
        $bukti = $this->request->getFile('bukti_bayar');
        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            $newName = $bukti->getRandomName();
            $bukti->move('uploads/pembayaran', $newName);
            $data['bukti_bayar'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan pembayaran');
        }

        // Update tagihan
        $newTerbayar = $tagihan['terbayar'] + $data['nominal'];
        $newSisa = $tagihan['total'] - $newTerbayar;
        
        $this->tagihanModel->update($tagihanId, [
            'terbayar' => $newTerbayar,
            'sisa' => $newSisa,
        ]);
        $this->tagihanModel->updateStatus($tagihanId);

        return redirect()->to("/tagihan/view/{$tagihanId}")
            ->with('success', 'Pembayaran berhasil disimpan');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();
        $pembayaran = $db->table('pembayaran')
            ->select('pembayaran.*, tagihan_keluarga.no_tagihan, users.nama_lengkap as kasir')
            ->join('tagihan_keluarga', 'tagihan_keluarga.id = pembayaran.tagihan_id')
            ->join('users', 'users.id = pembayaran.user_id', 'left')
            ->where('pembayaran.id', $id)
            ->get()
            ->getRowArray();

        if (!$pembayaran) {
            return redirect()->to('/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pembayaran',
            'breadcrumb' => [
                ['title' => 'Data Pembayaran', 'url' => base_url('pembayaran'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'pembayaran' => $pembayaran,
        ];
        return view('pembayaran/view', $data);
    }

    public function delete($id)
    {
        $pembayaran = $this->model->find($id);
        if (!$pembayaran) {
            return redirect()->to('/pembayaran')->with('error', 'Data tidak ditemukan');
        }

        // Revert tagihan
        $tagihan = $this->tagihanModel->find($pembayaran['tagihan_id']);
        if ($tagihan) {
            $newTerbayar = $tagihan['terbayar'] - $pembayaran['nominal'];
            $newSisa = $tagihan['total'] - $newTerbayar;
            
            $this->tagihanModel->update($tagihan['id'], [
                'terbayar' => max(0, $newTerbayar),
                'sisa' => $newSisa,
            ]);
            $this->tagihanModel->updateStatus($tagihan['id']);
        }

        // Delete bukti file
        if ($pembayaran['bukti_bayar'] && file_exists('uploads/pembayaran/' . $pembayaran['bukti_bayar'])) {
            unlink('uploads/pembayaran/' . $pembayaran['bukti_bayar']);
        }

        $this->model->delete($id);
        return redirect()->to('/pembayaran')->with('success', 'Pembayaran berhasil dihapus');
    }
}
