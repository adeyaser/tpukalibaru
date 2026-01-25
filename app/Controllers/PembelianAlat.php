<?php

namespace App\Controllers;

use App\Models\PembelianAlatModel;

class PembelianAlat extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PembelianAlatModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Pembelian Alat',
            'breadcrumb' => [['title' => 'Pembelian Alat', 'active' => true]],
            'pembelian' => $this->model->orderBy('tanggal_beli', 'DESC')->findAll(),
        ];
        return view('pembelian/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pembelian Alat',
            'breadcrumb' => [
                ['title' => 'Pembelian Alat', 'url' => base_url('pembelian'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('pembelian/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['no_pembelian'] = $this->model->generateNoPembelian();
        $data['total_harga'] = ($data['jumlah'] ?? 1) * ($data['harga_satuan'] ?? 0);
        $data['user_id'] = session()->get('userId');

        // Handle bukti upload
        $bukti = $this->request->getFile('bukti');
        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            $newName = $bukti->getRandomName();
            $bukti->move('uploads/pembelian', $newName);
            $data['bukti'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to('/pembelian')->with('success', 'Pembelian alat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pembelian = $this->model->find($id);
        if (!$pembelian) {
            return redirect()->to('/pembelian')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pembelian Alat',
            'breadcrumb' => [
                ['title' => 'Pembelian Alat', 'url' => base_url('pembelian'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'pembelian' => $pembelian,
        ];
        return view('pembelian/edit', $data);
    }

    public function update($id)
    {
        $pembelian = $this->model->find($id);
        if (!$pembelian) {
            return redirect()->to('/pembelian')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;
        $data['total_harga'] = ($data['jumlah'] ?? 1) * ($data['harga_satuan'] ?? 0);

        // Handle bukti upload
        $bukti = $this->request->getFile('bukti');
        if ($bukti && $bukti->isValid() && !$bukti->hasMoved()) {
            if ($pembelian['bukti'] && file_exists('uploads/pembelian/' . $pembelian['bukti'])) {
                unlink('uploads/pembelian/' . $pembelian['bukti']);
            }
            $newName = $bukti->getRandomName();
            $bukti->move('uploads/pembelian', $newName);
            $data['bukti'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to('/pembelian')->with('success', 'Pembelian alat berhasil diperbarui');
    }

    public function delete($id)
    {
        $pembelian = $this->model->find($id);
        if (!$pembelian) {
            return redirect()->to('/pembelian')->with('error', 'Data tidak ditemukan');
        }

        if ($pembelian['bukti'] && file_exists('uploads/pembelian/' . $pembelian['bukti'])) {
            unlink('uploads/pembelian/' . $pembelian['bukti']);
        }

        $this->model->delete($id);
        return redirect()->to('/pembelian')->with('success', 'Pembelian alat berhasil dihapus');
    }
}
