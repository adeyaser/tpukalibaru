<?php

namespace App\Models;

use CodeIgniter\Model;

class ComproMessageModel extends Model
{
    protected $table            = 'compro_messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama', 'email', 'subject', 'pesan', 'is_read', 'ip_address', 'user_agent'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
