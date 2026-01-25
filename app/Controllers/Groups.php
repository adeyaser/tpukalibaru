<?php

namespace App\Controllers;

use App\Models\GroupModel;
use App\Models\MenuModel;

class Groups extends BaseController
{
    protected $model;
    protected $menuModel;

    public function __construct()
    {
        $this->model = new GroupModel();
        $this->menuModel = new MenuModel();
        helper('acl');
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Group',
            'breadcrumb' => [['title' => 'Manajemen Group', 'active' => true]],
            'groups' => $this->model->findAll(),
        ];
        return view('groups/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Group',
            'breadcrumb' => [
                ['title' => 'Manajemen Group', 'url' => base_url('groups'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
        ];
        return view('groups/create', $data);
    }

    public function store()
    {
        if (!$this->model->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/groups')->with('success', 'Group berhasil ditambahkan');
    }

    public function edit($id)
    {
        $group = $this->model->find($id);
        if (!$group) {
            return redirect()->to('/groups')->with('error', 'Group tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Group',
            'breadcrumb' => [
                ['title' => 'Manajemen Group', 'url' => base_url('groups'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'group' => $group,
        ];
        return view('groups/edit', $data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $data['id'] = $id;

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }
        return redirect()->to('/groups')->with('success', 'Group berhasil diperbarui');
    }

    public function delete($id)
    {
        $group = $this->model->find($id);
        if (!$group) {
            return redirect()->to('/groups')->with('error', 'Group tidak ditemukan');
        }

        // Check if group has users
        $db = \Config\Database::connect();
        $userCount = $db->table('user_groups')->where('group_id', $id)->countAllResults();
        if ($userCount > 0) {
            return redirect()->to('/groups')
                ->with('error', 'Tidak dapat menghapus group yang masih memiliki user');
        }

        // Delete permissions
        $db->table('menu_permissions')->where('group_id', $id)->delete();

        $this->model->delete($id);
        return redirect()->to('/groups')->with('success', 'Group berhasil dihapus');
    }

    public function permissions($id)
    {
        $group = $this->model->find($id);
        if (!$group) {
            return redirect()->to('/groups')->with('error', 'Group tidak ditemukan');
        }

        $menus = $this->menuModel->orderBy('urutan', 'ASC')->findAll();
        
        // Get current permissions
        $db = \Config\Database::connect();
        $permissions = $db->table('menu_permissions')
            ->where('group_id', $id)
            ->get()
            ->getResultArray();

        $permissionMap = [];
        foreach ($permissions as $p) {
            $permissionMap[$p['menu_id']] = $p;
        }

        $data = [
            'title' => 'Hak Akses - ' . $group['nama_group'],
            'breadcrumb' => [
                ['title' => 'Manajemen Group', 'url' => base_url('groups'), 'active' => false],
                ['title' => 'Hak Akses', 'active' => true],
            ],
            'group' => $group,
            'menus' => $menus,
            'permissions' => $permissionMap,
        ];
        return view('groups/permissions', $data);
    }

    public function savePermissions($id)
    {
        $group = $this->model->find($id);
        if (!$group) {
            return redirect()->to('/groups')->with('error', 'Group tidak ditemukan');
        }

        $db = \Config\Database::connect();
        
        // Delete existing permissions
        $db->table('menu_permissions')->where('group_id', $id)->delete();

        // Insert new permissions
        $menus = $this->request->getPost('menus') ?? [];
        foreach ($menus as $menuId => $perms) {
            $db->table('menu_permissions')->insert([
                'group_id' => $id,
                'menu_id' => $menuId,
                'can_view' => isset($perms['view']) ? 1 : 0,
                'can_create' => isset($perms['create']) ? 1 : 0,
                'can_update' => isset($perms['update']) ? 1 : 0,
                'can_delete' => isset($perms['delete']) ? 1 : 0,
            ]);
        }

        return redirect()->to("/groups/permissions/{$id}")->with('success', 'Hak akses berhasil disimpan');
    }
}
