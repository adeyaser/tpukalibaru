<?php

namespace App\Models;

use CodeIgniter\Model;

class JenazahModel extends Model
{
    protected $table = 'jenazah';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 
        'tanggal_wafat', 'jenis_kelamin', 'agama', 'alamat', 
        'penyebab_kematian', 'foto'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'nama_lengkap' => 'required|max_length[100]',
        'tanggal_wafat' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'agama' => 'required',
    ];

    public function getWithKeluarga(int $id)
    {
        $jenazah = $this->find($id);
        if (!$jenazah) return null;

        $db = \Config\Database::connect();
        $jenazah['keluarga'] = $db->table('keluarga_jenazah')
            ->where('jenazah_id', $id)
            ->get()
            ->getResultArray();

        return $jenazah;
    }

    public function getWithPemakaman(int $id)
    {
        $jenazah = $this->find($id);
        if (!$jenazah) return null;

        $db = \Config\Database::connect();
        $jenazah['pemakaman'] = $db->table('pemakaman')
            ->select('pemakaman.*, lokasi_makam.nama_blok, lokasi_makam.kode_blok')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('pemakaman.jenazah_id', $id)
            ->get()
            ->getRowArray();

        return $jenazah;
    }
}
