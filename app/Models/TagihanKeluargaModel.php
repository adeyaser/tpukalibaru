<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanKeluargaModel extends Model
{
    protected $table = 'tagihan_keluarga';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'no_tagihan', 'pemakaman_id', 'keluarga_id', 'jenis_tagihan',
        'periode_mulai', 'periode_akhir', 'nominal', 'denda', 'total',
        'terbayar', 'sisa', 'jatuh_tempo', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateNoTagihan(): string
    {
        $prefix = 'TGH' . date('Ymd');
        $last = $this->like('no_tagihan', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        $sequence = $last ? ((int)substr($last['no_tagihan'], -4) + 1) : 1;
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function updateStatus(int $id)
    {
        $tagihan = $this->find($id);
        if (!$tagihan) return;

        $status = 'belum_bayar';
        if ($tagihan['sisa'] <= 0) {
            $status = 'lunas';
        } elseif ($tagihan['terbayar'] > 0) {
            $status = 'cicilan';
        }

        $this->update($id, ['status' => $status]);
    }

    public function getAllWithDetails()
    {
        $db = \Config\Database::connect();
        return $db->table('tagihan_keluarga')
            ->select('tagihan_keluarga.*, jenazah.nama_lengkap as nama_jenazah,
                      keluarga_jenazah.nama_lengkap as nama_keluarga, keluarga_jenazah.no_telepon')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('keluarga_jenazah', 'keluarga_jenazah.id = tagihan_keluarga.keluarga_id')
            ->orderBy('tagihan_keluarga.created_at', 'DESC')
            ->get()
            ->getResultArray();
    }
}
