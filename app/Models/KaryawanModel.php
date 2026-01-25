<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nip', 'nama_lengkap', 'jabatan', 'no_telepon', 'email',
        'alamat', 'tanggal_masuk', 'gaji_pokok', 'status', 'foto'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'nip' => 'required|max_length[20]|is_unique[karyawan.nip,id,{id}]',
        'nama_lengkap' => 'required|max_length[100]',
        'jabatan' => 'required|max_length[50]',
        'tanggal_masuk' => 'required|valid_date',
        'gaji_pokok' => 'required|decimal',
    ];

    public function generateNip(): string
    {
        $prefix = 'EMP' . date('Y');
        $last = $this->like('nip', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        $sequence = $last ? ((int)substr($last['nip'], -4) + 1) : 1;
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getAktif()
    {
        return $this->where('status', 'aktif')->findAll();
    }
}
