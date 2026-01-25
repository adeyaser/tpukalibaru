<?php

namespace App\Controllers;

class Reports extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['acl', 'setting']);
    }

    public function pemakaman()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        $data = $this->getPemakamanData($startDate, $endDate);
        
        $data['title'] = 'Laporan Pemakaman';
        $data['breadcrumb'] = [['title' => 'Laporan Pemakaman', 'active' => true]];
        
        return view('reports/pemakaman', $data);
    }

    public function perawatan()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        $data = $this->getPerawatanData($startDate, $endDate);
        
        $data['title'] = 'Laporan Perawatan Makam';
        $data['breadcrumb'] = [['title' => 'Laporan Perawatan', 'active' => true]];
        
        return view('reports/perawatan', $data);
    }

    public function keuangan()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');

        $data = $this->getKeuanganData($startDate, $endDate);
        
        $data['title'] = 'Laporan Keuangan';
        $data['breadcrumb'] = [['title' => 'Laporan Keuangan', 'active' => true]];
        
        return view('reports/keuangan', $data);
    }

    public function export($type)
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');
        
        $dompdf = new \Dompdf\Dompdf();
        $filename = 'Laporan_' . ucfirst($type) . '_' . date('Ymd');
        
        switch ($type) {
            case 'pemakaman':
                $data = $this->getPemakamanData($startDate, $endDate);
                $html = view('reports/print_pemakaman', $data);
                $dompdf->setPaper('A4', 'landscape');
                break;
                
            case 'perawatan':
                $data = $this->getPerawatanData($startDate, $endDate);
                $html = view('reports/print_perawatan', $data);
                $dompdf->setPaper('A4', 'landscape');
                break;
                
            case 'keuangan':
                $data = $this->getKeuanganData($startDate, $endDate);
                $html = view('reports/print_keuangan', $data);
                $dompdf->setPaper('A4', 'portrait');
                break;
                
            default:
                return redirect()->back()->with('error', 'Jenis laporan tidak valid');
        }
        
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream($filename . '.pdf', ['Attachment' => 0]);
        exit;
    }

    private function getPemakamanData($startDate, $endDate)
    {
        $pemakaman = $this->db->table('pemakaman')
            ->select('pemakaman.*, jenazah.nama_lengkap as nama_jenazah, jenazah.tanggal_wafat,
                      lokasi_makam.kode_blok, lokasi_makam.nama_blok')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('DATE(pemakaman.tanggal_pemakaman) >=', $startDate)
            ->where('DATE(pemakaman.tanggal_pemakaman) <=', $endDate)
            ->orderBy('pemakaman.tanggal_pemakaman', 'DESC')
            ->get()
            ->getResultArray();

        // Summary by lokasi
        $summaryByLokasi = $this->db->table('pemakaman')
            ->select('lokasi_makam.nama_blok, COUNT(*) as total')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('DATE(pemakaman.tanggal_pemakaman) >=', $startDate)
            ->where('DATE(pemakaman.tanggal_pemakaman) <=', $endDate)
            ->groupBy('lokasi_makam.id')
            ->get()
            ->getResultArray();

        return [
            'pemakaman' => $pemakaman,
            'summaryByLokasi' => $summaryByLokasi,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => count($pemakaman),
        ];
    }

    private function getPerawatanData($startDate, $endDate)
    {
        $perawatan = $this->db->table('perawatan_makam')
            ->select('perawatan_makam.*, pemakaman.no_makam, jenazah.nama_lengkap, lokasi_makam.nama_blok')
            ->select('(SELECT status FROM tagihan_keluarga WHERE pemakaman_id = pemakaman.id ORDER BY created_at DESC LIMIT 1) as payment_status')
            ->join('pemakaman', 'pemakaman.id = perawatan_makam.pemakaman_id')
            ->join('jenazah', 'jenazah.id = pemakaman.jenazah_id')
            ->join('lokasi_makam', 'lokasi_makam.id = pemakaman.lokasi_makam_id')
            ->where('DATE(perawatan_makam.tanggal_perawatan) >=', $startDate)
            ->where('DATE(perawatan_makam.tanggal_perawatan) <=', $endDate)
            ->groupBy('perawatan_makam.id')
            ->orderBy('perawatan_makam.tanggal_perawatan', 'DESC')
            ->get()
            ->getResultArray();

        // Total biaya
        $totalBiaya = $this->db->table('perawatan_makam')
            ->where('DATE(tanggal_perawatan) >=', $startDate)
            ->where('DATE(tanggal_perawatan) <=', $endDate)
            ->selectSum('biaya')
            ->get()
            ->getRow()->biaya ?? 0;

        return [
            'perawatan' => $perawatan,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'total' => count($perawatan),
            'totalBiaya' => $totalBiaya,
        ];
    }

    private function getKeuanganData($startDate, $endDate)
    {
        // Pendapatan (Pembayaran)
        $pendapatan = $this->db->table('pembayaran')
            ->where('DATE(tanggal_bayar) >=', $startDate)
            ->where('DATE(tanggal_bayar) <=', $endDate)
            ->selectSum('nominal')
            ->get()
            ->getRow()->nominal ?? 0;

        $pembayaranList = $this->db->table('pembayaran')
            ->select('pembayaran.*, tagihan_keluarga.no_tagihan')
            ->join('tagihan_keluarga', 'tagihan_keluarga.id = pembayaran.tagihan_id')
            ->where('DATE(pembayaran.tanggal_bayar) >=', $startDate)
            ->where('DATE(pembayaran.tanggal_bayar) <=', $endDate)
            ->orderBy('pembayaran.tanggal_bayar', 'DESC')
            ->get()
            ->getResultArray();

        // Pengeluaran
        $pengeluaran = $this->db->table('pengeluaran')
            ->where('DATE(tanggal) >=', $startDate)
            ->where('DATE(tanggal) <=', $endDate)
            ->selectSum('nominal')
            ->get()
            ->getRow()->nominal ?? 0;

        $pengeluaranList = $this->db->table('pengeluaran')
            ->select('pengeluaran.*')
            ->where('DATE(tanggal) >=', $startDate)
            ->where('DATE(tanggal) <=', $endDate)
            ->orderBy('tanggal', 'DESC')
            ->get()
            ->getResultArray();

        // Pembelian Alat
        $pembelian = $this->db->table('pembelian_alat')
            ->where('DATE(tanggal_beli) >=', $startDate)
            ->where('DATE(tanggal_beli) <=', $endDate)
            ->selectSum('total_harga')
            ->get()
            ->getRow()->total_harga ?? 0;

        // Gaji
        $gaji = $this->db->table('gaji')
            ->where('status', 'dibayar')
            ->where('DATE(tanggal_bayar) >=', $startDate)
            ->where('DATE(tanggal_bayar) <=', $endDate)
            ->selectSum('total_gaji')
            ->get()
            ->getRow()->total_gaji ?? 0;

        $totalPengeluaran = $pengeluaran + $pembelian + $gaji;
        $saldo = $pendapatan - $totalPengeluaran;

        return [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'pendapatan' => $pendapatan,
            'pengeluaran' => $pengeluaran,
            'pembelian' => $pembelian,
            'gaji' => $gaji,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,
            'pembayaranList' => $pembayaranList,
            'pengeluaranList' => $pengeluaranList,
        ];
    }
}
