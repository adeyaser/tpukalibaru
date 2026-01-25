<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproAboutModel extends Model
{
    protected $table            = 'compro_about';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'deskripsi', 'visi', 'misi', 'gambar', 'updated_at'];
}
