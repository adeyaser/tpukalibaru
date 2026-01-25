<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproGalleryModel extends Model
{
    protected $table            = 'compro_gallery';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'deskripsi', 'gambar', 'kategori', 'urutan', 'is_active'];
}
