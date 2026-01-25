<?php

namespace App\Models;

use CodeIgniter\Model;

class TunjanganModel extends Model
{
    protected $table = 'tunjangan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['nama_tunjangan', 'nominal', 'deskripsi', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama_tunjangan' => 'required|max_length[50]',
        'nominal' => 'required|decimal',
    ];

    public function getAktif()
    {
        return $this->where('is_active', 1)->findAll();
    }
}
