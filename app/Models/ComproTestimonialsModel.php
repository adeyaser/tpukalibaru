<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproTestimonialsModel extends Model
{
    protected $table            = 'compro_testimonials';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nama', 'relasi', 'testimoni', 'foto', 'rating', 'is_active'];
}
