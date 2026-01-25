<?php

namespace App\Controllers;

use App\Models\JenazahModel;
use App\Models\PemakamanModel;
use App\Models\KaryawanModel;
use App\Models\TagihanKeluargaModel;
use App\Models\PembayaranModel;
use App\Models\PengeluaranModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Get statistics
        $db = \Config\Database::connect();
        
        // Total jenazah
        $totalJenazah = $db->table('jenazah')->countAllResults();
        
        // Total pemakaman aktif
        $totalPemakaman = $db->table('pemakaman')
            ->where('status', 'aktif')
            ->countAllResults();
        
        // Total lokasi makam
        $totalLokasi = $db->table('lokasi_makam')->countAllResults();
        $kapasitasTotal = $db->table('lokasi_makam')->selectSum('kapasitas')->get()->getRow()->kapasitas ?? 0;
        $terisiTotal = $db->table('lokasi_makam')->selectSum('terisi')->get()->getRow()->terisi ?? 0;
        
        // Total karyawan aktif
        $totalKaryawan = $db->table('karyawan')
            ->where('status', 'aktif')
            ->countAllResults();
        
        // Tagihan belum lunas bulan ini
        $tagihanBelumLunas = $db->table('tagihan_keluarga')
            ->where('status !=', 'lunas')
            ->selectSum('sisa')
            ->get()
            ->getRow()->sisa ?? 0;
        
        // Pendapatan bulan ini
        $bulanIni = date('Y-m');
        $pendapatanBulanIni = $db->table('pembayaran')
            ->where("DATE_FORMAT(tanggal_bayar, '%Y-%m') =", $bulanIni)
            ->selectSum('nominal')
            ->get()
            ->getRow()->nominal ?? 0;
        
        // Pengeluaran bulan ini
        $pengeluaranBulanIni = $db->table('pengeluaran')
            ->where("DATE_FORMAT(tanggal, '%Y-%m') =", $bulanIni)
            ->selectSum('nominal')
            ->get()
            ->getRow()->nominal ?? 0;
        
        // Chart data - Pemakaman per bulan (6 bulan terakhir)
        $chartLabels = [];
        $chartPemakaman = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $chartLabels[] = date('M Y', strtotime("-$i months"));
            $count = $db->table('pemakaman')
                ->where("DATE_FORMAT(tanggal_pemakaman, '%Y-%m') =", $month)
                ->countAllResults();
            $chartPemakaman[] = $count;
        }
        
        // Chart data - Pendapatan vs Pengeluaran
        $chartPendapatan = [];
        $chartPengeluaran = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            
            $pendapatan = $db->table('pembayaran')
                ->where("DATE_FORMAT(tanggal_bayar, '%Y-%m') =", $month)
                ->selectSum('nominal')
                ->get()
                ->getRow()->nominal ?? 0;
            $chartPendapatan[] = (int)$pendapatan;
            
            $pengeluaran = $db->table('pengeluaran')
                ->where("DATE_FORMAT(tanggal, '%Y-%m') =", $month)
                ->selectSum('nominal')
                ->get()
                ->getRow()->nominal ?? 0;
            $chartPengeluaran[] = (int)$pengeluaran;
        }
        
        // Recent pemakaman
        $recentPemakaman = $db->table('pemakaman')
            ->select('pemakaman.*, jenazah.nama_lengkap, lokasi_makam.nama_blok')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->orderBy('pemakaman.created_at', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        // Tagihan jatuh tempo
        $tagihanJatuhTempo = $db->table('tagihan_keluarga')
            ->select('tagihan_keluarga.*, jenazah.nama_lengkap')
            ->join('pemakaman', 'pemakaman.id = tagihan_keluarga.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->where('tagihan_keluarga.status !=', 'lunas')
            ->where('tagihan_keluarga.jatuh_tempo <=', date('Y-m-d', strtotime('+7 days')))
            ->orderBy('tagihan_keluarga.jatuh_tempo', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();
        
        // Total Unread Messages
        $unreadMessages = $db->table('compro_messages')
            ->where('is_read', 0)
            ->where('deleted_at', null)
            ->countAllResults();
        
        $data = [
            'title' => 'Dashboard',
            'totalJenazah' => $totalJenazah,
            'totalPemakaman' => $totalPemakaman,
            'totalLokasi' => $totalLokasi,
            'kapasitasTotal' => $kapasitasTotal,
            'terisiTotal' => $terisiTotal,
            'tersediaTotal' => $kapasitasTotal - $terisiTotal,
            'totalKaryawan' => $totalKaryawan,
            'tagihanBelumLunas' => $tagihanBelumLunas,
            'pendapatanBulanIni' => $pendapatanBulanIni,
            'pengeluaranBulanIni' => $pengeluaranBulanIni,
            'chartLabels' => json_encode($chartLabels),
            'chartPemakaman' => json_encode($chartPemakaman),
            'chartPendapatan' => json_encode($chartPendapatan),
            'chartPengeluaran' => json_encode($chartPengeluaran),
            'recentPemakaman' => $recentPemakaman,
            'tagihanJatuhTempo' => $tagihanJatuhTempo,
            'unreadMessages' => $unreadMessages,
        ];
        
        return view('dashboard/index', $data);
    }
}
