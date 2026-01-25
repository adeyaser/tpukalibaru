<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanKeluargaItemModel extends Model
{
    protected $table            = 'tagihan_keluarga_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['tagihan_id', 'nama_item', 'nominal'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
