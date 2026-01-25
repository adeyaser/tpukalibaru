<?php

namespace App\Controllers;

use App\Models\KeluargaJenazahModel;
use App\Models\JenazahModel;

class KeluargaJenazah extends BaseController
{
    protected $model;
    protected $jenazahModel;

    public function __construct()
    {
        $this->model = new KeluargaJenazahModel();
        $this->jenazahModel = new JenazahModel();
        helper('acl');
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $keluarga = $db->table('keluarga_jenazah')
            ->select('keluarga_jenazah.*, jenazah.nama_lengkap as nama_jenazah')
            ->join('jenazah', 'jenazah.id = keluarga_jenazah.jenazah_id')
            ->orderBy('keluarga_jenazah.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $data = [
            'title' => 'Data Keluarga',
            'breadcrumb' => [['title' => 'Data Keluarga', 'active' => true]],
            'keluarga' => $keluarga,
        ];
        return view('keluarga/index', $data);
    }

    public function create($jenazahId = null)
    {
        $data = [
            'title' => 'Tambah Data Keluarga',
        ];

        if ($jenazahId) {
            $jenazah = $this->jenazahModel->find($jenazahId);
            if (!$jenazah) {
                return redirect()->to('/jenazah')->with('error', 'Jenazah tidak ditemukan');
            }
            $data['jenazah'] = $jenazah;
            $data['breadcrumb'] = [
                ['title' => 'Data Jenazah', 'url' => base_url('jenazah'), 'active' => false],
                ['title' => $jenazah['nama_lengkap'], 'url' => base_url("jenazah/view/{$jenazahId}"), 'active' => false],
                ['title' => 'Tambah Keluarga', 'active' => true],
            ];
        } else {
            $data['jenazah'] = null;
            $data['daftar_jenazah'] = $this->jenazahModel->findAll();
            $data['breadcrumb'] = [
                ['title' => 'Data Keluarga', 'url' => base_url('keluarga'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ];
        }

        return view('keluarga/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        
        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to("/jenazah/view/{$data['jenazah_id']}")
            ->with('success', 'Data keluarga berhasil ditambahkan');
    }

    public function edit($id)
    {
        $keluarga = $this->model->find($id);
        if (!$keluarga) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $jenazah = $this->jenazahModel->find($keluarga['jenazah_id']);

        $data = [
            'title' => 'Edit Data Keluarga',
            'breadcrumb' => [
                ['title' => 'Data Jenazah', 'url' => base_url('jenazah'), 'active' => false],
                ['title' => 'Edit Keluarga', 'active' => true],
            ],
            'keluarga' => $keluarga,
            'jenazah' => $jenazah,
        ];
        return view('keluarga/edit', $data);
    }

    public function update($id)
    {
        $keluarga = $this->model->find($id);
        if (!$keluarga) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        
        return redirect()->to("/jenazah/view/{$keluarga['jenazah_id']}")
            ->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function delete($id)
    {
        $keluarga = $this->model->find($id);
        if (!$keluarga) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }

        $jenazahId = $keluarga['jenazah_id'];
        $this->model->delete($id);
        
        return redirect()->to("/jenazah/view/{$jenazahId}")
            ->with('success', 'Data keluarga berhasil dihapus');
    }
}
