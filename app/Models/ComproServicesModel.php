<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproServicesModel extends Model
{
    protected $table            = 'compro_services';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama_layanan', 'deskripsi', 'icon', 'gambar', 'harga', 'urutan', 'is_active'];
}
