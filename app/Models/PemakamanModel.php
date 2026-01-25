<?php

namespace App\Models;

use CodeIgniter\Model;

class PemakamanModel extends Model
{
    protected $table = 'pemakaman';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'no_makam', 'jenazah_id', 'lokasi_makam_id', 'tanggal_pemakaman',
        'baris', 'nomor', 'biaya_pemakaman', 'biaya_perawatan_tahunan',
        'masa_berlaku', 'status', 'catatan', 'user_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'jenazah_id' => 'required|integer',
        'lokasi_makam_id' => 'required|integer',
        'tanggal_pemakaman' => 'required|valid_date',
    ];

    public function generateNoMakam(string $kodeBlok): string
    {
        $year = date('Y');
        $month = date('m');
        
        $lastNo = $this->like('no_makam', "{$kodeBlok}/{$year}{$month}", 'after')
                       ->orderBy('id', 'DESC')
                       ->first();
        
        if ($lastNo) {
            $parts = explode('/', $lastNo['no_makam']);
            $sequence = (int)end($parts) + 1;
        } else {
            $sequence = 1;
        }
        
        return "{$kodeBlok}/{$year}{$month}/" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getWithDetails(int $id)
    {
        return $this->select('pemakaman.*, jenazah.nama_lengkap as nama_jenazah, jenazah.nik,
                             jenazah.tanggal_wafat, jenazah.agama, jenazah.jenis_kelamin,
                             lokasi_makam.kode_blok, lokasi_makam.nama_blok')
                    ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
                    ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
                    ->where('pemakaman.id', $id)
                    ->first();
    }

    public function getAllWithDetails()
    {
        return $this->select('pemakaman.*, jenazah.nama_lengkap as nama_jenazah,
                             lokasi_makam.kode_blok, lokasi_makam.nama_blok')
                    ->select('(SELECT id FROM keluarga_jenazah WHERE jenazah_id = pemakaman.jenazah_id AND is_penanggung_jawab = 1 LIMIT 1) as keluarga_id')
                    ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
                    ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
                    ->orderBy('pemakaman.created_at', 'DESC')
                    ->findAll();
    }
}
