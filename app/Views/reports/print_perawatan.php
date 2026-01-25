<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perawatan Makam</title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16pt; }
        .header p { margin: 2px 0; }
        h3 { text-align: center; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; font-size: 9pt; }
        th { background-color: #eee; text-align: center; }
        .text-center { text-align: center; }
        .text-end { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= esc(get_setting('nama_tpu') ?: get_setting('site_title', 'SI-MAKAM')) ?></h1>
        <p><?= esc(get_setting('site_address', '')) ?></p>
        <p>Email: <?= esc(get_setting('site_email', '-')) ?> | Telp: <?= esc(get_setting('site_phone', '-')) ?></p>
    </div>

    <h3>LAPORAN PERAWATAN MAKAM</h3>
    <p class="text-center">Periode: <?= date('d M Y', strtotime($startDate)) ?> s/d <?= date('d M Y', strtotime($endDate)) ?></p>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Jenazah</th>
                <th>No Makam</th>
                <th>Lokasi</th>
                <th>Jenis</th>
                <th>Status Kerja</th>
                <th>Status Bayar</th>
                <th>Biaya</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $statusLabels = [
                'lunas' => 'Sudah Dibayarkan',
                'cicilan' => 'Sudah Dibayarkan (Cicilan)',
                'belum_bayar' => 'Belum Dibayarkan',
            ];
            foreach ($perawatan as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal_perawatan'])) ?></td>
                    <td><?= esc($p['nama_lengkap']) ?></td>
                    <td><?= esc($p['no_makam']) ?></td>
                    <td><?= esc($p['nama_blok']) ?></td>
                    <td><?= ucfirst($p['jenis_perawatan']) ?></td>
                    <td class="text-center"><?= ucfirst($p['status']) ?></td>
                    <td class="text-center"><?= $statusLabels[$p['payment_status']] ?? 'Belum Ditagih' ?></td>
                    <td class="text-end"><?= format_rupiah($p['biaya']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($perawatan)): ?>
                <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="8" class="text-end">TOTAL BIAYA</th>
                <th class="text-end"><?= format_rupiah($totalBiaya) ?></th>
            </tr>
        </tfoot>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Bekasi, <?= date('d M Y') ?><br>Kepala TPU</p>
        <br><br><br>
        <p>( ................................. )</p>
    </div>
</body>
</html>
