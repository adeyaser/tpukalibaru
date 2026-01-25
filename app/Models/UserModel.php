<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'username', 'email', 'password', 'nama_lengkap', 
        'foto', 'status', 'last_login'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username,id,{id}]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan',
        ],
        'email' => [
            'is_unique' => 'Email sudah terdaftar',
        ],
    ];

    /**
     * Get user by username or email
     */
    public function findByLogin(string $login)
    {
        return $this->where('username', $login)
                    ->orWhere('email', $login)
                    ->first();
    }

    /**
     * Get user with their groups
     */
    public function getUserWithGroups(int $userId)
    {
        $user = $this->find($userId);
        if (!$user) return null;

        $db = \Config\Database::connect();
        $groups = $db->table('user_groups')
            ->select('groups.*')
            ->join('groups', 'groups.id = user_groups.group_id')
            ->where('user_groups.user_id', $userId)
            ->get()
            ->getResultArray();

        $user['groups'] = $groups;
        return $user;
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Hash password before insert/update
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash(
                $data['data']['password'], 
                PASSWORD_DEFAULT
            );
        }
        return $data;
    }

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Update last login time
     */
    public function updateLastLogin(int $userId)
    {
        return $this->update($userId, ['last_login' => date('Y-m-d H:i:s')]);
    }
}
