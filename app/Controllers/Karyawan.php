<?php

namespace App\Controllers;

use App\Models\KaryawanModel;

class Karyawan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KaryawanModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Karyawan',
            'breadcrumb' => [['title' => 'Data Karyawan', 'active' => true]],
            'karyawan' => $this->model->findAll(),
        ];
        return view('karyawan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Karyawan',
            'breadcrumb' => [
                ['title' => 'Data Karyawan', 'url' => base_url('karyawan'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'nip' => $this->model->generateNip(),
        ];
        return view('karyawan/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads/karyawan', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to('/karyawan')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function view($id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan');
        }

        // Get gaji history
        $db = \Config\Database::connect();
        $karyawan['gaji'] = $db->table('gaji')
            ->where('karyawan_id', $id)
            ->orderBy('tahun', 'DESC')
            ->orderBy('bulan', 'DESC')
            ->limit(12)
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Detail Karyawan',
            'breadcrumb' => [
                ['title' => 'Data Karyawan', 'url' => base_url('karyawan'), 'active' => false],
                ['title' => 'Detail', 'active' => true],
            ],
            'karyawan' => $karyawan,
        ];
        return view('karyawan/view', $data);
    }

    public function edit($id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Karyawan',
            'breadcrumb' => [
                ['title' => 'Data Karyawan', 'url' => base_url('karyawan'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'karyawan' => $karyawan,
        ];
        return view('karyawan/edit', $data);
    }

    public function update($id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($karyawan['foto'] && file_exists('uploads/karyawan/' . $karyawan['foto'])) {
                unlink('uploads/karyawan/' . $karyawan['foto']);
            }
            $newName = $foto->getRandomName();
            $foto->move('uploads/karyawan', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to("/karyawan/view/{$id}")->with('success', 'Karyawan berhasil diperbarui');
    }

    public function delete($id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) {
            return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan');
        }

        if ($karyawan['foto'] && file_exists('uploads/karyawan/' . $karyawan['foto'])) {
            unlink('uploads/karyawan/' . $karyawan['foto']);
        }

        $this->model->delete($id);
        return redirect()->to('/karyawan')->with('success', 'Karyawan berhasil dihapus');
    }
}
