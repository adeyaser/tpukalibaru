<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\GroupModel;

class Users extends BaseController
{
    protected $model;
    protected $groupModel;

    public function __construct()
    {
        $this->model = new UserModel();
        $this->groupModel = new GroupModel();
        helper('acl');
    }

    public function index()
    {
        $db = \Config\Database::connect();
        $users = $this->model->findAll();

        // Get groups for each user
        foreach ($users as &$user) {
            $userGroups = $db->table('user_groups')
                ->select('groups.nama_group')
                ->join('groups', 'groups.id = user_groups.group_id')
                ->where('user_groups.user_id', $user['id'])
                ->get()
                ->getResultArray();
            $user['groups'] = array_column($userGroups, 'nama_group');
        }

        $data = [
            'title' => 'Manajemen User',
            'breadcrumb' => [['title' => 'Manajemen User', 'active' => true]],
            'users' => $users,
        ];
        return view('users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'breadcrumb' => [
                ['title' => 'Manajemen User', 'url' => base_url('users'), 'active' => false],
                ['title' => 'Tambah', 'active' => true],
            ],
            'groups' => $this->groupModel->findAll(),
        ];
        return view('users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[users.username]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nama_lengkap' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', implode('<br>', $this->validator->getErrors()));
        }

        $data = $this->request->getPost();
        
        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getRandomName();
            $foto->move('uploads/users', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan user');
        }

        $userId = $this->model->getInsertID();

        // Assign groups
        $groups = $this->request->getPost('groups') ?? [];
        $db = \Config\Database::connect();
        foreach ($groups as $groupId) {
            $db->table('user_groups')->insert([
                'user_id' => $userId,
                'group_id' => $groupId,
            ]);
        }

        return redirect()->to('/users')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        $db = \Config\Database::connect();
        $userGroups = $db->table('user_groups')
            ->where('user_id', $id)
            ->get()
            ->getResultArray();
        $user['group_ids'] = array_column($userGroups, 'group_id');

        $data = [
            'title' => 'Edit User',
            'breadcrumb' => [
                ['title' => 'Manajemen User', 'url' => base_url('users'), 'active' => false],
                ['title' => 'Edit', 'active' => true],
            ],
            'user' => $user,
            'groups' => $this->groupModel->findAll(),
        ];
        return view('users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        $data = $this->request->getPost();
        $data['id'] = $id;

        // Remove password if empty
        if (empty($data['password'])) {
            unset($data['password']);
        }

        // Handle foto upload
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($user['foto'] && file_exists('uploads/users/' . $user['foto'])) {
                unlink('uploads/users/' . $user['foto']);
            }
            $newName = $foto->getRandomName();
            $foto->move('uploads/users', $newName);
            $data['foto'] = $newName;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()
                ->with('error', 'Gagal menyimpan: ' . implode(', ', $this->model->errors()));
        }

        // Update groups
        $db = \Config\Database::connect();
        $db->table('user_groups')->where('user_id', $id)->delete();

        $groups = $this->request->getPost('groups') ?? [];
        foreach ($groups as $groupId) {
            $db->table('user_groups')->insert([
                'user_id' => $id,
                'group_id' => $groupId,
            ]);
        }

        return redirect()->to('/users')->with('success', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $user = $this->model->find($id);
        if (!$user) {
            return redirect()->to('/users')->with('error', 'User tidak ditemukan');
        }

        // Prevent deleting self
        if ($id == session()->get('userId')) {
            return redirect()->to('/users')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        // Delete user groups
        $db = \Config\Database::connect();
        $db->table('user_groups')->where('user_id', $id)->delete();

        // Delete foto
        if ($user['foto'] && file_exists('uploads/users/' . $user['foto'])) {
            unlink('uploads/users/' . $user['foto']);
        }

        $this->model->delete($id);
        return redirect()->to('/users')->with('success', 'User berhasil dihapus');
    }
}
