<?php

namespace App\Controllers;

use App\Models\MenuModel;

class Menus extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MenuModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Menu',
            'breadcrumb' => [['title' => 'Manajemen Menu', 'active' => true]],
            'menus' => $this->model->orderBy('urutan', 'ASC')->findAll(),
        ];
        return view('menus/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Menu',
            'breadcrumb' => [
                ['title' => 'Manajemen Menu', 'url' => base_url('menus'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'parents' => $this->model->where('parent_id', null)->findAll(),
        ];
        return view('menus/create', $data);
    }

    public function store()
    {
        $data = $this->request->getPost();
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan menu');
        }
        return redirect()->to('/menus')->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            return redirect()->to('/menus')->with('error', 'Menu tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Menu',
            'breadcrumb' => [
                ['title' => 'Manajemen Menu', 'url' => base_url('menus'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'menu' => $menu,
            'parents' => $this->model->where('parent_id', null)->where('id !=', $id)->findAll(),
        ];
        return view('menus/edit', $data);
    }

    public function update($id)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            return redirect()->to('/menus')->with('error', 'Menu tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;
        if (empty($data['parent_id'])) {
            $data['parent_id'] = null;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan menu');
        }
        return redirect()->to('/menus')->with('success', 'Menu berhasil diperbarui');
    }

    public function delete($id)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            return redirect()->to('/menus')->with('error', 'Menu tidak ditemukan');
        }

        // Check for children
        $children = $this->model->where('parent_id', $id)->countAllResults();
        if ($children > 0) {
            return redirect()->to('/menus')
                ->with('error', 'Tidak dapat menghapus menu yang memiliki sub-menu');
        }

        // Delete permissions
        $db = \Config\Database::connect();
        $db->table('menu_permissions')->where('menu_id', $id)->delete();

        $this->model->delete($id);
        return redirect()->to('/menus')->with('success', 'Menu berhasil dihapus');
    }
}
