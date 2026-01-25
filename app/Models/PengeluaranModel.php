<?php

namespace App\Models;

use CodeIgniter\Model;

class PengeluaranModel extends Model
{
    protected $table = 'pengeluaran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'no_pengeluaran', 'kategori', 'deskripsi', 'nominal',
        'tanggal', 'bukti', 'user_id', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateNoPengeluaran(): string
    {
        $prefix = 'EXP' . date('Ymd');
        $last = $this->like('no_pengeluaran', $prefix, 'after')
                     ->orderBy('id', 'DESC')
                     ->first();
        
        $sequence = $last ? ((int)substr($last['no_pengeluaran'], -4) + 1) : 1;
        return $prefix . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    public function getByDateRange($startDate, $endDate)
    {
        return $this->where('tanggal >=', $startDate)
                    ->where('tanggal <=', $endDate)
                    ->orderBy('tanggal', 'DESC')
                    ->findAll();
    }

    public function getTotalByKategori($startDate = null, $endDate = null)
    {
        $builder = $this->builder();
        $builder->select('kategori, SUM(nominal) as total')
                ->groupBy('kategori');
        
        if ($startDate) $builder->where('tanggal >=', $startDate);
        if ($endDate) $builder->where('tanggal <=', $endDate);
        
        return $builder->get()->getResultArray();
    }
}
