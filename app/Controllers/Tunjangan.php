<?php

namespace App\Controllers;

use App\Models\TunjanganModel;

class Tunjangan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new TunjanganModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Master Tunjangan',
            'breadcrumb' => [['title' => 'Master Tunjangan', 'active' => true]],
            'tunjangan' => $this->model->findAll(),
        ];
        return view('tunjangan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Tunjangan',
            'breadcrumb' => [
                ['title' => 'Master Tunjangan', 'url' => base_url('tunjangan'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('tunjangan/create', $data);
    }

    public function store()
    {
        if (!$this->model->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/tunjangan')->with('success', 'Tunjangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $tunjangan = $this->model->find($id);
        if (!$tunjangan) {
            return redirect()->to('/tunjangan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Tunjangan',
            'breadcrumb' => [
                ['title' => 'Master Tunjangan', 'url' => base_url('tunjangan'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'tunjangan' => $tunjangan,
        ];
        return view('tunjangan/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/tunjangan')->with('success', 'Tunjangan berhasil diperbarui');
    }

    public function delete($id)
    {
        $tunjangan = $this->model->find($id);
        if (!$tunjangan) {
            return redirect()->to('/tunjangan')->with('error', 'Data tidak ditemukan');
        }

        $this->model->delete($id);
        return redirect()->to('/tunjangan')->with('success', 'Tunjangan berhasil dihapus');
    }
}
