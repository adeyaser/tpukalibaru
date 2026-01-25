<?php

namespace App\Models;

use CodeIgniter\Model;

class GajiModel extends Model
{
    protected $table = 'gaji';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'karyawan_id', 'periode', 'gaji_pokok', 'total_tunjangan',
        'potongan', 'total_gaji', 'tanggal_bayar', 'status', 'catatan'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getWithKaryawan()
    {
        $db = \Config\Database::connect();
        return $db->table('gaji')
            ->select('gaji.*, karyawan.nip, karyawan.nama_lengkap, karyawan.jabatan')
            ->join('karyawan', 'karyawan.id = gaji.karyawan_id')
            ->orderBy('gaji.periode', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function exists(int $karyawanId, string $periode, $excludeId = null): bool
    {
        $builder = $this->where('karyawan_id', $karyawanId)
                        ->where('periode', $periode);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }
}
