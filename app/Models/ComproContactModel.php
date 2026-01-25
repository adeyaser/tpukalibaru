<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproContactModel extends Model
{
    protected $table            = 'compro_contact';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['alamat', 'telepon', 'whatsapp', 'email', 'maps_embed', 'jam_operasional', 'facebook', 'instagram', 'updated_at'];
}
