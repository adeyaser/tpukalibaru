<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= $tagihan['no_tagihan'] ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 10px; }
        .invoice-info { width: 100%; margin-bottom: 20px; }
        .invoice-info td { vertical-align: top; }
        .invoice-info td.right { text-align: right; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; }
        .table td.text-right { text-align: right; }
        .total-section { float: right; width: 250px; }
        .total-item { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .total-item.grand-total { font-weight: bold; border-top: 1px solid #333; padding-top: 5px; margin-top: 10px; font-size: 14px; }
        .status-badge { display: inline-block; padding: 5px 10px; border-radius: 4px; color: #fff; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #000; }
        .bg-danger { background-color: #dc3545; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #777; border-top: 1px solid #ddd; padding-top: 10px; }
        .signature { margin-top: 50px; text-align: right; margin-right: 50px; }
    </style>
</head>
<body>
    <div class="header">
        <h2><?= esc(get_setting('nama_tpu') ?: get_setting('site_title', 'TPU SI-MAKAM')) ?></h2>
        <p><?= esc(get_setting('site_address', '')) ?></p>
        <p>Email: <?= esc(get_setting('site_email', '-')) ?> | Telp: <?= esc(get_setting('site_phone', '-')) ?></p>
    </div>

    <table class="invoice-info">
        <tr>
            <td width="55%">
                <div style="margin-bottom: 10px;">
                    <strong>Tagihan Kepada:</strong><br>
                    <span style="font-size: 14px; font-weight: bold;"><?= esc($tagihan['nama_keluarga']) ?></span><br>
                    Telp: <?= esc($tagihan['no_telepon']) ?>
                </div>
                <div>
                    <strong>Informasi Makam:</strong><br>
                    Makam: <?= esc($tagihan['no_makam']) ?> | Blok: <?= esc($tagihan['nama_blok']) ?><br>
                    Nama Jenazah: <?= esc($tagihan['nama_jenazah']) ?>
                </div>
            </td>
            <td class="right" width="45%">
                <table align="right" style="border-collapse: collapse;">
                    <tr>
                        <td class="text-right" style="padding: 2px 5px;"><strong>No. Tagihan:</strong></td>
                        <td style="padding: 2px 5px;"><?= esc($tagihan['no_tagihan']) ?></td>
                    </tr>
                    <tr>
                        <td class="text-right" style="padding: 2px 5px;"><strong>Tanggal:</strong></td>
                        <td style="padding: 2px 5px;"><?= date('d/m/Y', strtotime($tagihan['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-right" style="padding: 2px 5px;"><strong>Jatuh Tempo:</strong></td>
                        <td style="padding: 2px 5px;"><?= date('d/m/Y', strtotime($tagihan['jatuh_tempo'])) ?></td>
                    </tr>
                    <tr>
                        <td class="text-right" style="padding: 2px 5px;"><strong>Status:</strong></td>
                        <td style="padding: 2px 5px;">
                            <?php
                            $statusLabels = ['lunas' => 'Lunas', 'cicilan' => 'Cicilan', 'belum_bayar' => 'Belum Bayar'];
                            $statusColors = ['lunas' => '#28a745', 'cicilan' => '#ffc107', 'belum_bayar' => '#dc3545'];
                            $color = $statusColors[$tagihan['status']] ?? '#6c757d';
                            $textColor = ($tagihan['status'] == 'cicilan') ? '#000' : '#fff';
                            ?>
                            <span style="background-color: <?= $color ?>; color: <?= $textColor ?>; padding: 3px 8px; border-radius: 3px; font-weight: bold; font-size: 10px; text-transform: uppercase; white-space: nowrap;">
                                <?= $statusLabels[$tagihan['status']] ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th>Rincian Item</th>
                <th width="150" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($tagihan['items'])): ?>
                <tr>
                    <td>Biaya <?= ucfirst(str_replace('_', ' ', $tagihan['jenis_tagihan'])) ?></td>
                    <td class="text-right"><?= format_rupiah($tagihan['nominal']) ?></td>
                </tr>
            <?php else: ?>
                <?php foreach ($tagihan['items'] as $item): ?>
                    <tr>
                        <td><?= esc($item['nama_item']) ?></td>
                        <td class="text-right"><?= format_rupiah($item['nominal']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr>
                <td style="text-align: right;"><strong>Subtotal Nominal</strong></td>
                <td class="text-right"><?= format_rupiah($tagihan['nominal']) ?></td>
            </tr>
            <?php if ($tagihan['denda'] > 0): ?>
                <tr>
                    <td style="text-align: right; color: red;">Denda</td>
                    <td class="text-right" style="color: red;"><?= format_rupiah($tagihan['denda']) ?></td>
                </tr>
            <?php endif; ?>
            <tr style="font-size: 14px; font-weight: bold; background-color: #f2f2f2;">
                <td style="text-align: right;">Total Tagihan</td>
                <td class="text-right"><?= format_rupiah($tagihan['total']) ?></td>
            </tr>
            <tr>
                <td style="text-align: right;">Terbayar (-)</td>
                <td class="text-right text-success"><?= format_rupiah($tagihan['terbayar']) ?></td>
            </tr>
            <tr style="font-size: 14px; font-weight: bold; color: #dc3545;">
                <td style="text-align: right;">Sisa Tagihan</td>
                <td class="text-right"><?= format_rupiah($tagihan['sisa']) ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="signature">
        <p>Bekasi, <?= date('d F Y') ?></p>
        <br><br><br>
        <p><strong>Admin TPU</strong></p>
    </div>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Informasi Pemakaman (SI-MAKAM) pada <?= date('d/m/Y H:i:s') ?>
    </div>
</body>
</html>
