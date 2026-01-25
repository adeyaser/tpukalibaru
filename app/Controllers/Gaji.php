<?php

namespace App\Controllers;

use App\Models\GajiModel;
use App\Models\KaryawanModel;
use App\Models\TunjanganModel;

class Gaji extends BaseController
{
    protected $model;
    protected $karyawanModel;
    protected $tunjanganModel;

    public function __construct()
    {
        $this->model = new GajiModel();
        $this->karyawanModel = new KaryawanModel();
        $this->tunjanganModel = new TunjanganModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Gaji',
            'breadcrumb' => [['title' => 'Data Gaji', 'active' => true]],
            'gaji' => $this->model->getWithKaryawan(),
        ];
        return view('gaji/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Buat Slip Gaji',
            'breadcrumb' => [
                ['title' => 'Data Gaji', 'url' => base_url('gaji'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'karyawan' => $this->karyawanModel->getAktif(),
            'tunjangan' => $this->tunjanganModel->getAktif(),
            'bulan' => date('m'),
            'tahun' => date('Y'),
        ];
        return view('gaji/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        
        // Check if already exists
        if ($this->model->exists($data['karyawan_id'], $data['periode'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Slip gaji untuk karyawan ini pada periode tersebut sudah ada');
        }

        // Calculate totals
        $karyawan = $this->karyawanModel->find($data['karyawan_id']);
        $data['gaji_pokok'] = $data['gaji_pokok'] ?? $karyawan['gaji_pokok'];
        
        // Check if already exists
        if ($this->model->exists($data['karyawan_id'], $data['periode'])) {
            return redirect()->back()->withInput()
                ->with('error', 'Slip gaji untuk karyawan ini pada periode tersebut sudah ada');
        }

        // Calculate totals
        $karyawan = $this->karyawanModel->find($data['karyawan_id']);
        $data['gaji_pokok'] = $data['gaji_pokok'] ?? $karyawan['gaji_pokok'];
        
        // Map form fields to DB columns
        $data['potongan'] = $data['potongan'] ?? 0;
        $data['total_gaji'] = $data['gaji_pokok'] + ($data['total_tunjangan'] ?? 0) - $data['potongan'];

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan gaji');
        }
        
        return redirect()->to('/gaji')->with('success', 'Slip gaji berhasil dibuat');
    }

    public function view($id)
    {
        $db = \Config\Database::connect();
        $gaji = $db->table('gaji')
            ->select('gaji.*, karyawan.nip, karyawan.nama_lengkap, karyawan.jabatan')
            ->join('karyawan', 'karyawan.id = gaji.karyawan_id')
            ->where('gaji.id', $id)
            ->get()
            ->getRowArray();

        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Slip Gaji',
            'breadcrumb' => [
                ['title' => 'Data Gaji', 'url' => base_url('gaji'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'gaji' => $gaji,
        ];
        return view('gaji/view', $data);
    }
    
    // ... (edit/update/delete methods skipped as they use models) ...

    public function edit($id)
    {
        $gaji = $this->model->find($id);
        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        if ($gaji['status'] === 'dibayar') {
            return redirect()->to('/gaji')->with('error', 'Gaji yang sudah dibayar tidak dapat diedit');
        }

        $data = [
            'title' => 'Edit Slip Gaji',
            'breadcrumb' => [
                ['title' => 'Data Gaji', 'url' => base_url('gaji'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'gaji' => $gaji,
            'karyawan' => $this->karyawanModel->find($gaji['karyawan_id']),
            'tunjangan' => $this->tunjanganModel->getAktif(),
        ];
        return view('gaji/edit', $data);
    }

    public function update($id)
    {
        $gaji = $this->model->find($id);
        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;
        
        // Map form fields to DB columns
        $data['potongan'] = $data['potongan'] ?? 0;
        $data['total_gaji'] = ($data['gaji_pokok'] ?? $gaji['gaji_pokok']) 
                            + ($data['total_tunjangan'] ?? 0) 
                            - $data['potongan'];

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan');
        }
        
        return redirect()->to("/gaji/view/{$id}")->with('success', 'Slip gaji berhasil diperbarui');
    }

    public function delete($id)
    {
        $gaji = $this->model->find($id);
        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        if ($gaji['status'] === 'dibayar') {
            return redirect()->to('/gaji')->with('error', 'Gaji yang sudah dibayar tidak dapat dihapus');
        }

        $this->model->delete($id);
        return redirect()->to('/gaji')->with('success', 'Slip gaji berhasil dihapus');
    }

    public function bayar($id)
    {
        $gaji = $this->model->find($id);
        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        $this->model->update($id, [
            'status' => 'dibayar',
            'tanggal_bayar' => date('Y-m-d'),
        ]);

        return redirect()->to("/gaji/view/{$id}")->with('success', 'Gaji berhasil dibayarkan');
    }

    public function print($id)
    {
        $db = \Config\Database::connect();
        $gaji = $db->table('gaji')
            ->select('gaji.*, karyawan.nip, karyawan.nama_lengkap, karyawan.jabatan')
            ->join('karyawan', 'karyawan.id = gaji.karyawan_id')
            ->where('gaji.id', $id)
            ->get()
            ->getRowArray();

        if (!$gaji) {
            return redirect()->to('/gaji')->with('error', 'Data tidak ditemukan');
        }

        $dompdf = new \Dompdf\Dompdf();
        $html = view('gaji/print', ['gaji' => $gaji]);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $filename = 'Slip_Gaji_' . $gaji['nip'] . '_' . $gaji['periode'] . '.pdf';
        
        $dompdf->stream($filename, ['Attachment' => 0]);
        exit;
    }
}
