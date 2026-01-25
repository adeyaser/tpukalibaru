<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nama_group', 'deskripsi'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_group' => 'required|min_length[3]|max_length[50]|is_unique[groups.nama_group,id,{id}]',
    ];

    /**
     * Get users in a group
     */
    public function getGroupUsers(int $groupId)
    {
        $db = \Config\Database::connect();
        return $db->table('user_groups')
            ->select('users.*')
            ->join('users', 'users.id = user_groups.user_id')
            ->where('user_groups.group_id', $groupId)
            ->get()
            ->getResultArray();
    }

    /**
     * Get group permissions
     */
    public function getGroupPermissions(int $groupId)
    {
        $db = \Config\Database::connect();
        return $db->table('menu_permissions')
            ->select('menu_permissions.*, menus.nama_menu, menus.url')
            ->join('menus', 'menus.id = menu_permissions.menu_id')
            ->where('menu_permissions.group_id', $groupId)
            ->get()
            ->getResultArray();
    }
}
