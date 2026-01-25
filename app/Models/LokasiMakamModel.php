<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiMakamModel extends Model
{
    protected $table = 'lokasi_makam';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'kode_blok', 'nama_blok', 'kapasitas', 'terisi', 'harga_sewa', 'deskripsi'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'kode_blok' => 'required|max_length[20]|is_unique[lokasi_makam.kode_blok,id,{id}]',
        'nama_blok' => 'required|max_length[50]',
        'kapasitas' => 'required|integer|greater_than[0]',
    ];

    public function getTersedia()
    {
        return $this->select('*, (kapasitas - terisi) as tersedia')
                    ->where('kapasitas > terisi')
                    ->findAll();
    }

    public function incrementTerisi(int $id)
    {
        return $this->set('terisi', 'terisi + 1', false)->where('id', $id)->update();
    }

    public function decrementTerisi(int $id)
    {
        return $this->set('terisi', 'GREATEST(terisi - 1, 0)', false)->where('id', $id)->update();
    }
}
