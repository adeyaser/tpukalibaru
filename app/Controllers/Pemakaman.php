<?php

namespace App\Controllers;

use App\Models\PemakamanModel;
use App\Models\JenazahModel;
use App\Models\LokasiMakamModel;
use App\Models\KeluargaJenazahModel;
use App\Models\TagihanKeluargaModel;

class Pemakaman extends BaseController
{
    protected $model;
    protected $jenazahModel;
    protected $lokasiModel;

    public function __construct()
    {
        $this->model = new PemakamanModel();
        $this->jenazahModel = new JenazahModel();
        $this->lokasiModel = new LokasiMakamModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pemakaman',
            'breadcrumb' => [['title' => 'Data Pemakaman', 'active' => true]],
            'pemakaman' => $this->model->getAllWithDetails(),
        ];
        return view('pemakaman/index', $data);
    }

    public function create()
    {
        // Get jenazah that haven't been buried yet
        $db = \Config\Database::connect();
        $buriedIds = $db->table('pemakaman')->select('jenazah_id')->get()->getResultArray();
        $buriedIds = array_column($buriedIds, 'jenazah_id');
        
        $jenazahQuery = $this->jenazahModel->orderBy('nama_lengkap', 'ASC');
        if (!empty($buriedIds)) {
            $jenazahQuery->whereNotIn('id', $buriedIds);
        }
        $jenazah = $jenazahQuery->findAll();

        $data = [
            'title' => 'Tambah Data Pemakaman',
            'breadcrumb' => [
                ['title' => 'Data Pemakaman', 'url' => base_url('pemakaman'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'jenazah' => $jenazah,
            'lokasi' => $this->lokasiModel->getTersedia(),
        ];
        return view('pemakaman/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        // Get lokasi for generating no_makam
        $lokasi = $this->lokasiModel->find($data['lokasi_makam_id']);
        if (!$lokasi) {
            return redirect()->back()->withInput()->with('error', 'Lokasi tidak valid');
        }
        
        // Check capacity
        if ($lokasi['terisi'] >= $lokasi['kapasitas']) {
            return redirect()->back()->withInput()->with('error', 'Lokasi sudah penuh');
        }

        // Generate no_makam
        $data['no_makam'] = $this->model->generateNoMakam($lokasi['kode_blok']);
        $data['user_id'] = session()->get('userId');
        $data['biaya_pemakaman'] = $data['biaya_pemakaman'] ?? $lokasi['harga_sewa'];
        
        // Set masa berlaku (3 years default)
        if (empty($data['masa_berlaku'])) {
            $data['masa_berlaku'] = date('Y-m-d', strtotime('+3 years'));
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        // Increment terisi
        $this->lokasiModel->incrementTerisi($data['lokasi_makam_id']);
        
        $pemakamanId = $this->model->getInsertID();
        
        // Create initial tagihan for burial cost
        $keluargaModel = new KeluargaJenazahModel();
        $penanggungJawab = $keluargaModel->getPenanggungJawab($data['jenazah_id']);
        
        if ($penanggungJawab) {
            $tagihanModel = new TagihanKeluargaModel();
            $tagihanModel->save([
                'no_tagihan' => 'TGH' . date('Ymd') . str_pad($pemakamanId, 4, '0', STR_PAD_LEFT),
                'pemakaman_id' => $pemakamanId,
                'keluarga_id' => $penanggungJawab['id'],
                'jenis_tagihan' => 'pemakaman',
                'nominal' => $data['biaya_pemakaman'],
                'total' => $data['biaya_pemakaman'],
                'sisa' => $data['biaya_pemakaman'],
                'jatuh_tempo' => date('Y-m-d', strtotime('+30 days')),
            ]);
        }
        
        return redirect()->to("/pemakaman/view/{$pemakamanId}")
            ->with('success', 'Data pemakaman berhasil ditambahkan');
    }

    public function view($id)
    {
        $pemakaman = $this->model->getWithDetails($id);
        if (!$pemakaman) {
            return redirect()->to('/pemakaman')->with('error', 'Data tidak ditemukan');
        }

        // Get keluarga
        $keluargaModel = new KeluargaJenazahModel();
        $pemakaman['keluarga'] = $keluargaModel->where('jenazah_id', $pemakaman['jenazah_id'])->findAll();

        // Get tagihan
        $db = \Config\Database::connect();
        $pemakaman['tagihan'] = $db->table('tagihan_keluarga')
            ->where('pemakaman_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        // Get perawatan
        $pemakaman['perawatan'] = $db->table('perawatan_makam')
            ->where('pemakaman_id', $id)
            ->orderBy('tanggal_perawatan', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Pemakaman',
            'breadcrumb' => [
                ['title' => 'Data Pemakaman', 'url' => base_url('pemakaman'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'pemakaman' => $pemakaman,
        ];
        return view('pemakaman/view', $data);
    }

    public function edit($id)
    {
        $pemakaman = $this->model->find($id);
        if (!$pemakaman) {
            return redirect()->to('/pemakaman')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Pemakaman',
            'breadcrumb' => [
                ['title' => 'Data Pemakaman', 'url' => base_url('pemakaman'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'pemakaman' => $pemakaman,
            'lokasi' => $this->lokasiModel->findAll(),
        ];
        return view('pemakaman/edit', $data);
    }

    public function update($id)
    {
        $pemakaman = $this->model->find($id);
        if (!$pemakaman) {
            return redirect()->to('/pemakaman')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to("/pemakaman/view/{$id}")->with('success', 'Data pemakaman berhasil diperbarui');
    }

    public function delete($id)
    {
        $pemakaman = $this->model->find($id);
        if (!$pemakaman) {
            return redirect()->to('/pemakaman')->with('error', 'Data tidak ditemukan');
        }

        // Decrement terisi
        $this->lokasiModel->decrementTerisi($pemakaman['lokasi_makam_id']);
        
        $this->model->delete($id);
        return redirect()->to('/pemakaman')->with('success', 'Data pemakaman berhasil dihapus');
    }
}
