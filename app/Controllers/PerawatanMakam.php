<?php

namespace App\Controllers;

use App\Models\PerawatanMakamModel;
use App\Models\PemakamanModel;

class PerawatanMakam extends BaseController
{
    protected $model;
    protected $pemakamanModel;

    public function __construct()
    {
        $this->model = new PerawatanMakamModel();
        $this->pemakamanModel = new PemakamanModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Data Perawatan Makam',
            'breadcrumb' => [['title' => 'Perawatan Makam', 'active' => true]],
            'perawatan' => $this->model->getAllWithDetails(),
        ];
        return view('perawatan/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Perawatan',
            'breadcrumb' => [
                ['title' => 'Perawatan Makam', 'url' => base_url('perawatan'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'pemakaman' => $this->pemakamanModel->getAllWithDetails(),
        ];
        return view('perawatan/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['user_id'] = session()->get('userId');

        // Handle foto sebelum
        $fotoSebelum = $this->request->getFile('foto_sebelum');
        if ($fotoSebelum && $fotoSebelum->isValid() && !$fotoSebelum->hasMoved()) {
            $newName = $fotoSebelum->getRandomName();
            $fotoSebelum->move('uploads/perawatan', $newName);
            $data['foto_sebelum'] = $newName;
        }

        // Handle foto sesudah
        $fotoSesudah = $this->request->getFile('foto_sesudah');
        if ($fotoSesudah && $fotoSesudah->isValid() && !$fotoSesudah->hasMoved()) {
            $newName = $fotoSesudah->getRandomName();
            $fotoSesudah->move('uploads/perawatan', $newName);
            $data['foto_sesudah'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan perawatan');
        }
        
        return redirect()->to('/perawatan')->with('success', 'Perawatan makam berhasil ditambahkan');
    }

    public function edit($id)
    {
        $perawatan = $this->model->getDetail($id);
        if (!$perawatan) {
            return redirect()->to('/perawatan')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Perawatan',
            'breadcrumb' => [
                ['title' => 'Perawatan Makam', 'url' => base_url('perawatan'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'perawatan' => $perawatan,
            'pemakaman' => $this->pemakamanModel->getAllWithDetails(),
        ];
        return view('perawatan/edit', $data);
    }

    public function update($id)
    {
        $perawatan = $this->model->find($id);
        if (!$perawatan) {
            return redirect()->to('/perawatan')->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        // Handle foto uploads
        foreach (['foto_sebelum', 'foto_sesudah'] as $field) {
            $foto = $this->request->getFile($field);
            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                if ($perawatan[$field] && file_exists('uploads/perawatan/' . $perawatan[$field])) {
                    unlink('uploads/perawatan/' . $perawatan[$field]);
                }
                $newName = $foto->getRandomName();
                $foto->move('uploads/perawatan', $newName);
                $data[$field] = $newName;
            }
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan');
        }
        
        return redirect()->to('/perawatan')->with('success', 'Perawatan makam berhasil diperbarui');
    }

    public function delete($id)
    {
        $perawatan = $this->model->find($id);
        if (!$perawatan) {
            return redirect()->to('/perawatan')->with('error', 'Data tidak ditemukan');
        }

        // Delete photos
        foreach (['foto_sebelum', 'foto_sesudah'] as $field) {
            if ($perawatan[$field] && file_exists('uploads/perawatan/' . $perawatan[$field])) {
                unlink('uploads/perawatan/' . $perawatan[$field]);
            }
        }

        $this->model->delete($id);
        return redirect()->to('/perawatan')->with('success', 'Perawatan makam berhasil dihapus');
    }
}
