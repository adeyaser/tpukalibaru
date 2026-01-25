<?php

namespace App\Models;

use CodeIgniter\Model;

class PerawatanMakamModel extends Model
{
    protected $table = 'perawatan_makam';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'pemakaman_id', 'tanggal_perawatan', 'jenis_perawatan', 'deskripsi',
        'biaya', 'foto_sebelum', 'foto_sesudah', 'status', 'petugas', 'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getAllWithDetails()
    {
        $db = \Config\Database::connect();
        return $db->table('perawatan_makam')
            ->select('perawatan_makam.*, pemakaman.no_makam, jenazah.nama_lengkap, lokasi_makam.nama_blok')
            ->join('pemakaman', 'pemakaman.id = perawatan_makam.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->orderBy('perawatan_makam.tanggal_perawatan', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getDetail($id)
    {
        $db = \Config\Database::connect();
        return $db->table('perawatan_makam')
            ->select('perawatan_makam.*, pemakaman.no_makam, jenazah.nama_lengkap as nama_jenazah, lokasi_makam.nama_blok')
            ->join('pemakaman', 'pemakaman.id = perawatan_makam.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('perawatan_makam.id', $id)
            ->get()
            ->getRowArray();
    }
}
