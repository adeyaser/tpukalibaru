<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pemakaman</title>
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
        .summary { margin-top: 20px; width: 40%; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?= esc(get_setting('nama_tpu') ?: get_setting('site_title', 'SI-MAKAM')) ?></h1>
        <p><?= esc(get_setting('site_address', '')) ?></p>
        <p>Email: <?= esc(get_setting('site_email', '-')) ?> | Telp: <?= esc(get_setting('site_phone', '-')) ?></p>
    </div>

    <h3>LAPORAN PEMAKAMAN</h3>
    <p class="text-center">Periode: <?= date('d M Y', strtotime($startDate)) ?> s/d <?= date('d M Y', strtotime($endDate)) ?></p>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="80">Tanggal</th>
                <th>Nama Jenazah</th>
                <th>Tanggal Wafat</th>
                <th>Blok</th>
                <th width="60">Jam</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            foreach ($pemakaman as $p): ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal_pemakaman'])) ?></td>
                    <td><?= esc($p['nama_jenazah']) ?></td>
                    <td class="text-center"><?= date('d/m/Y', strtotime($p['tanggal_wafat'])) ?></td>
                    <td><?= esc($p['nama_blok']) ?> (<?= esc($p['kode_blok']) ?>)</td>
                    <td class="text-center"><?= date('H:i', strtotime($p['tanggal_pemakaman'])) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($pemakaman)): ?>
                <tr><td colspan="6" class="text-center">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="summary">
        <h4>Ringkasan Per Blok:</h4>
        <table>
            <thead>
                <tr>
                    <th>Blok</th>
                    <th class="text-center">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($summaryByLokasi as $sum): ?>
                    <tr>
                        <td><?= esc($sum['nama_blok']) ?></td>
                        <td class="text-center"><?= $sum['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <p>Bekasi, <?= date('d M Y') ?><br>Kepala TPU</p>
        <br><br><br>
        <p>( ................................. )</p>
    </div>
</body>
</html>
