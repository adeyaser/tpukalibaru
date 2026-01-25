<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproHeroModel extends Model
{
    protected $table            = 'compro_hero';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['judul', 'subjudul', 'cta_text', 'cta_url', 'background_image', 'is_active', 'updated_at'];
}
