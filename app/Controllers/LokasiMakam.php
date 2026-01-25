<?php

namespace App\Controllers;

use App\Models\LokasiMakamModel;

class LokasiMakam extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new LokasiMakamModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Lokasi Makam',
            'breadcrumb' => [['title' => 'Lokasi Makam', 'active' => true]],
            'lokasi' => $this->model->findAll(),
        ];
        return view('lokasi_makam/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Lokasi Makam',
            'breadcrumb' => [
                ['title' => 'Lokasi Makam', 'url' => base_url('lokasi-makam'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('lokasi_makam/create', $data);
    }

    public function store()
    {
        if (!$this->model->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/lokasi-makam')->with('success', 'Lokasi makam berhasil ditambahkan');
    }

    public function edit($id)
    {
        $lokasi = $this->model->find($id);
        if (!$lokasi) {
            return redirect()->to('/lokasi-makam')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Lokasi Makam',
            'breadcrumb' => [
                ['title' => 'Lokasi Makam', 'url' => base_url('lokasi-makam'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'lokasi' => $lokasi,
        ];
        return view('lokasi_makam/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/lokasi-makam')->with('success', 'Lokasi makam berhasil diperbarui');
    }

    public function delete($id)
    {
        $lokasi = $this->model->find($id);
        if (!$lokasi) {
            return redirect()->to('/lokasi-makam')->with('error', 'Data tidak ditemukan');
        }

        if ($lokasi['terisi'] > 0) {
            return redirect()->to('/lokasi-makam')
                ->with('error', 'Tidak dapat menghapus lokasi yang sudah terisi makam');
        }

        $this->model->delete($id);
        return redirect()->to('/lokasi-makam')->with('success', 'Lokasi makam berhasil dihapus');
    }
}
