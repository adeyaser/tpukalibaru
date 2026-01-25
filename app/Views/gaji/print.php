<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - <?= esc($gaji['no_ref'] ?? $gaji['id']) ?></title>
    <style>
        body { font-family: sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18pt; }
        .header p { margin: 2px 0; }
        .title { text-align: center; font-weight: bold; font-size: 14pt; margin: 20px 0; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 4px; vertical-align: top; }
        .text-end { text-align: right; }
        .fw-bold { font-weight: bold; }
        .border-top { border-top: 1px solid #000; }
        .border-bottom { border-bottom: 1px solid #000; }
        .total-row td { padding-top: 10px; font-size: 11pt; border-top: 1px solid #000; }
        .signature { margin-top: 50px; text-align: right; }
        .signature p { margin-bottom: 50px; }
    </style>
</head>
<body>
    <?php
    // Helper to format date
    $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    $periode = date('n', strtotime($gaji['periode'] . '-01'));
    $tahun = date('Y', strtotime($gaji['periode'] . '-01'));
    ?>

    <div class="header">
        <h1><?= get_setting('nama_tpu') ?: get_setting('site_title', 'SI-MAKAM') ?></h1>
        <p><?= get_setting('site_address', 'Jl. Ketenangan No. 123, Jakarta Selatan') ?></p>
        <p>Telp: <?= get_setting('site_phone', '021-12345678') ?> | Email: <?= get_setting('site_email', 'info@serenity-memorial.id') ?></p>
    </div>

    <div class="title">SLIP GAJI KARYAWAN</div>

    <table style="margin-bottom: 20px;">
        <tr>
            <td width="15%">Periode</td>
            <td width="35%">: <?= $bulanNama[$periode] . ' ' . $tahun ?></td>
            <td width="15%">Status</td>
            <td width="35%">: <?= ucfirst($gaji['status']) ?></td>
        </tr>
        <tr>
            <td>NIP</td>
            <td>: <?= esc($gaji['nip']) ?></td>
            <td>Tanggal Cetak</td>
            <td>: <?= date('d M Y') ?></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>: <?= esc($gaji['nama_lengkap']) ?></td>
            <td>Jabatan</td>
            <td>: <?= esc($gaji['jabatan']) ?></td>
        </tr>
    </table>

    <table class="table">
        <tr style="background-color: #eee;">
            <th colspan="2" class="border-top border-bottom">RINCIAN PENDAPATAN</th>
        </tr>
        <tr>
            <td width="70%">Gaji Pokok</td>
            <td width="30%" class="text-end"><?= format_rupiah($gaji['gaji_pokok']) ?></td>
        </tr>
        <tr>
            <td>Tunjangan</td>
            <td class="text-end"><?= format_rupiah($gaji['total_tunjangan']) ?></td>
        </tr>
        <tr>
            <td class="fw-bold">Total Pendapatan</td>
            <td class="text-end fw-bold"><?= format_rupiah($gaji['gaji_pokok'] + $gaji['total_tunjangan']) ?></td>
        </tr>
    </table>

    <table class="table">
        <tr style="background-color: #eee;">
            <th colspan="2" class="border-top border-bottom">RINCIAN POTONGAN</th>
        </tr>
        <tr>
            <td width="70%">Potongan Lain-lain</td>
            <td width="30%" class="text-end"><?= format_rupiah($gaji['potongan']) ?></td>
        </tr>
        <tr>
            <td class="fw-bold">Total Potongan</td>
            <td class="text-end fw-bold"><?= format_rupiah($gaji['potongan']) ?></td>
        </tr>
    </table>

    <table class="table">
        <tr class="total-row">
            <td width="70%" class="fw-bold">TOTAL GAJI BERSIH</td>
            <td width="30%" class="text-end fw-bold"><?= format_rupiah($gaji['total_gaji']) ?></td>
        </tr>
        <tr>
            <td colspan="2" style="font-style: italic; font-size: 9pt; padding-top: 5px;">
                Terbilang: # <?= ucwords(terbilang($gaji['total_gaji'])) ?> Rupiah #
                <!-- Note: number_to_currency might need intl extension, if fails we suppress or use helper -->
            </td>
        </tr>
    </table>

    <?php if ($gaji['catatan']): ?>
    <div style="border: 1px dashed #999; padding: 10px; margin-top: 10px; font-style: italic;">
        <strong>Catatan:</strong><br>
        <?= nl2br(esc($gaji['catatan'])) ?>
    </div>
    <?php endif; ?>

    <div class="signature">
        <p>Bekasi, <?= date('d M Y') ?><br>Manager Keuangan</p>
        <br><br><br>
        <p style="font-weight: bold; text-decoration: underline;">( ................................. )</p>
    </div>
</body>
</html>
