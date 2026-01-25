<?php

namespace App\Models;

use CodeIgniter\Model;

class KeluargaJenazahModel extends Model
{
    protected $table = 'keluarga_jenazah';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'jenazah_id', 'nama_lengkap', 'hubungan', 'nik', 
        'no_telepon', 'email', 'alamat', 'is_penanggung_jawab'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'jenazah_id' => 'required|integer',
        'nama_lengkap' => 'required|max_length[100]',
        'hubungan' => 'required|max_length[50]',
        'no_telepon' => 'required|max_length[20]',
    ];

    public function getPenanggungJawab(int $jenazahId)
    {
        return $this->where('jenazah_id', $jenazahId)
                    ->where('is_penanggung_jawab', 1)
                    ->first();
    }
}
