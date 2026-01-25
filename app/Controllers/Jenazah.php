<?php

namespace App\Controllers;

use App\Models\JenazahModel;
use App\Models\KeluargaJenazahModel;

class Jenazah extends BaseController
{
    protected $model;
    protected $keluargaModel;

    public function __construct()
    {
        $this->model = new JenazahModel();
        $this->keluargaModel = new KeluargaJenazahModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Jenazah',
            'breadcrumb' => [['title' => 'Data Jenazah', 'active' => true]],
            'jenazah' => $this->model->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('jenazah/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Data Jenazah',
            'breadcrumb' => [
                ['title' => 'Data Jenazah', 'url' => base_url('jenazah'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('jenazah/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        // Handle photo upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads/jenazah', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        $jenazahId = $this->model->getInsertID();
        return redirect()->to("/jenazah/view/{$jenazahId}")
            ->with('success', 'Data jenazah berhasil ditambahkan. Silakan tambahkan data keluarga.');
    }

    public function view($id)
    {
        $jenazah = $this->model->getWithKeluarga($id);
        if (!$jenazah) {
            return redirect()->to('/jenazah')->with('error', 'Data tidak ditemukan');
        }

        // Get pemakaman if exists
        $db = \Config\Database::connect();
        $jenazah['pemakaman'] = $db->table('pemakaman')
            ->select('pemakaman.*, lokasi_makam.nama_blok, lokasi_makam.kode_blok')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id', 'left')
            ->where('pemakaman.jenazah_id', $id)
            ->get()
            ->getRowArray();

        $data = [
            'title' => 'Detail Jenazah',
            'breadcrumb' => [
                ['title' => 'Data Jenazah', 'url' => base_url('jenazah'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'jenazah' => $jenazah,
        ];
        return view('jenazah/view', $data);
    }

    public function edit($id)
    {
        $jenazah = $this->model->find($id);
        if (!$jenazah) {
            return redirect()->to('/jenazah')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Jenazah',
            'breadcrumb' => [
                ['title' => 'Data Jenazah', 'url' => base_url('jenazah'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'jenazah' => $jenazah,
        ];
        return view('jenazah/edit', $data);
    }

    public function update($id)
    {
        $jenazah = $this->model->find($id);
        if (!$jenazah) {
            return redirect()->to('/jenazah')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        // Handle photo upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Delete old photo
            if ($jenazah['foto'] && file_exists('uploads/jenazah/' . $jenazah['foto'])) {
                unlink('uploads/jenazah/' . $jenazah['foto']);
            }
            $newName = $foto->getRandomName();
            $foto->move('uploads/jenazah', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to("/jenazah/view/{$id}")->with('success', 'Data jenazah berhasil diperbarui');
    }

    public function delete($id)
    {
        $jenazah = $this->model->find($id);
        if (!$jenazah) {
            return redirect()->to('/jenazah')->with('error', 'Data tidak ditemukan');
        }

        // Check if has burial
        $db = \Config\Database::connect();
        $hasBurial = $db->table('pemakaman')->where('jenazah_id', $id)->countAllResults() > 0;
        if ($hasBurial) {
            return redirect()->to('/jenazah')
                ->with('error', 'Tidak dapat menghapus jenazah yang sudah dimakamkan');
        }

        // Delete related family data
        $this->keluargaModel->where('jenazah_id', $id)->delete();
        
        // Delete photo
        if ($jenazah['foto'] && file_exists('uploads/jenazah/' . $jenazah['foto'])) {
            unlink('uploads/jenazah/' . $jenazah['foto']);
        }

        $this->model->delete($id);
        return redirect()->to('/jenazah')->with('success', 'Data jenazah berhasil dihapus');
    }
}
