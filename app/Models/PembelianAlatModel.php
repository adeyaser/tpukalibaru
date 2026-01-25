<?php

namespace App\Models;

use CodeIgniter\Model;

class PembelianAlatModel extends Model
{
    protected $table = 'pembelian_alat';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'no_pembelian', 'nama_barang', 'jumlah', 'satuan',
        'harga_satuan', 'total_harga', 'tanggal_beli', 'supplier', 'bukti', 'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateNoPembelian(): string
    {
        $prefix = 'PUR' . date('Ymd');
        $last = $this->like('no_pembelian', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        $sequence = $last ? ((int)substr($last['no_pembelian'], -4) + 1) : 1;
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
