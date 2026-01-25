<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16pt; }
        .header p { margin: 2px 0; }
        h3 { text-align: center; margin-top: 20px; }
        .summary-box { border: 1px solid #000; padding: 10px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; font-size: 9pt; }
        th { background-color: #eee; text-align: center; border: 1px solid #000; }
        td { border: 1px solid #ccc; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
        .section-title { font-weight: bold; margin-top: 20px; margin-bottom: 5px; text-decoration: underline; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= esc(get_setting('nama_tpu') ?: get_setting('site_title', 'SI-MAKAM')) ?></h1>
        <p><?= esc(get_setting('site_address', '')) ?></p>
        <p>Email: <?= esc(get_setting('site_email', '-')) ?> | Telp: <?= esc(get_setting('site_phone', '-')) ?></p>
    </div>

    <h3>LAPORAN KEUANGAN</h3>
    <p class="text-center">Periode: <?= date('d M Y', strtotime($startDate)) ?> s/d <?= date('d M Y', strtotime($endDate)) ?></p>

    <div class="summary-box">
        <table style="border: none;">
            <tr>
                <td style="border: none; width: 33%;">
                    <strong>Total Pendapatan:</strong><br>
                    <span style="font-size: 12pt;"><?= format_rupiah($pendapatan) ?></span>
                </td>
                <td style="border: none; width: 33%;">
                    <strong>Total Pengeluaran:</strong><br>
                    <span style="font-size: 12pt;"><?= format_rupiah($totalPengeluaran) ?></span>
                </td>
                <td style="border: none; width: 33%;">
                    <strong>Saldo Akhir:</strong><br>
                    <span style="font-size: 12pt;"><?= format_rupiah($saldo) ?></span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">RINCIAN PENGELUARAN</div>
    <table>
        <tr>
            <th width="30%">Kategori</th>
            <th class="text-end">Nominal</th>
        </tr>
        <tr>
            <td>Biaya Operasional</td>
            <td class="text-end"><?= format_rupiah($pengeluaran) ?></td>
        </tr>
        <tr>
            <td>Pembelian Alat/Aset</td>
            <td class="text-end"><?= format_rupiah($pembelian) ?></td>
        </tr>
        <tr>
            <td>Gaji Karyawan</td>
            <td class="text-end"><?= format_rupiah($gaji) ?></td>
        </tr>
        <tr style="font-weight: bold; background-color: #f9f9f9;">
            <td>TOTAL PENGELUARAN</td>
            <td class="text-end"><?= format_rupiah($totalPengeluaran) ?></td>
        </tr>
    </table>

    <div class="section-title">RIWAYAT PEMASUKAN (PEMBAYARAN)</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>No. Transaksi</th>
                <th>Tanggal</th>
                <th>No. Tagihan</th>
                <th>Metode</th>
                <th class="text-end">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($pembayaranList as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= esc($p['no_pembayaran']) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal_bayar'])) ?></td>
                    <td class="text-center"><?= esc($p['no_tagihan']) ?></td>
                    <td class="text-center"><?= ucfirst($p['metode_bayar']) ?></td>
                    <td class="text-end"><?= format_rupiah($p['nominal']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pembayaranList)): ?>
                <tr><td colspan="6" class="text-center">Tidak ada data pemasukan</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="section-title">RIWAYAT PENGELUARAN & OPERASIONAL</div>
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th>No. Pengeluaran</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th class="text-end">Nominal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($pengeluaranList as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= esc($p['no_pengeluaran']) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal'])) ?></td>
                    <td><?= esc($p['kategori']) ?></td>
                    <td><?= esc($p['deskripsi']) ?></td>
                    <td class="text-end"><?= format_rupiah($p['nominal']) ?></td>
                    <td class="text-center"><?= ucfirst($p['status']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pengeluaranList)): ?>
                <tr><td colspan="7" class="text-center">Tidak ada data pengeluaran</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Bekasi, <?= date('d M Y') ?><br>Manager Keuangan</p>
        <br><br><br>
        <p>( ................................. )</p>
    </div>
</body>
</html>
