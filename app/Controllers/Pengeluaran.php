<?php

namespace App\Controllers;

use App\Models\PengeluaranModel;

class Pengeluaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PengeluaranModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pengeluaran',
            'breadcrumb' => [['title' => 'Data Pengeluaran', 'active' => true]],
            'pengeluaran' => $this->model->orderBy('tanggal', 'DESC')->findAll(),
        ];
        return view('pengeluaran/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengeluaran',
            'breadcrumb' => [
                ['title' => 'Data Pengeluaran', 'url' => base_url('pengeluaran'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('pengeluaran/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['no_pengeluaran'] = $this->model->generateNoPengeluaran();
        $data['user_id'] = session()->get('userId');

        // Handle bukti upload
        $bukti = $this->request->getFile('bukti');
        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            $newName = $bukti->getRandomName();
            $bukti->move('uploads/pengeluaran', $newName);
            $data['bukti'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to('/pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pengeluaran = $this->model->find($id);
        if (!$pengeluaran) {
            return redirect()->to('/pengeluaran')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengeluaran',
            'breadcrumb' => [
                ['title' => 'Data Pengeluaran', 'url' => base_url('pengeluaran'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'pengeluaran' => $pengeluaran,
        ];
        return view('pengeluaran/edit', $data);
    }

    public function update($id)
    {
        $pengeluaran = $this->model->find($id);
        if (!$pengeluaran) {
            return redirect()->to('/pengeluaran')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        // Handle bukti upload
        $bukti = $this->request->getFile('bukti');
        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            if ($pengeluaran['bukti'] && file_exists('uploads/pengeluaran/' . $pengeluaran['bukti'])) {
                unlink('uploads/pengeluaran/' . $pengeluaran['bukti']);
            }
            $newName = $bukti->getRandomName();
            $bukti->move('uploads/pengeluaran', $newName);
            $data['bukti'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to('/pengeluaran')->with('success', 'Pengeluaran berhasil diperbarui');
    }

    public function delete($id)
    {
        $pengeluaran = $this->model->find($id);
        if (!$pengeluaran) {
            return redirect()->to('/pengeluaran')->with('error', 'Data tidak ditemukan');
        }

        if ($pengeluaran['bukti'] && file_exists('uploads/pengeluaran/' . $pengeluaran['bukti'])) {
            unlink('uploads/pengeluaran/' . $pengeluaran['bukti']);
        }

        $this->model->delete($id);
        return redirect()->to('/pengeluaran')->with('success', 'Pengeluaran berhasil dihapus');
    }
}
