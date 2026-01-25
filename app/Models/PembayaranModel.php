<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'no_pembayaran', 'tagihan_id', 'tanggal_bayar', 'nominal',
        'metode_bayar', 'bukti_bayar', 'catatan', 'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateNoPembayaran(): string
    {
        $prefix = 'PAY' . date('Ymd');
        $last = $this->like('no_pembayaran', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        $sequence = $last ? ((int)substr($last['no_pembayaran'], -4) + 1) : 1;
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getAllWithDetails()
    {
        $db = \Config\Database::connect();
        return $db->table('pembayaran')
            ->select('pembayaran.*, tagihan_keluarga.no_tagihan, jenazah.nama_lengkap as nama_jenazah')
            ->join('tagihan_keluarga', 'tagihan_keluarga.id = pembayaran.tagihan_id')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->orderBy('pembayaran.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
