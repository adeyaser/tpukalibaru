<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-receipt me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <?php if ($tagihan['status'] !== 'lunas'): ?>
            <a href="<?= base_url('pembayaran/create/' . $tagihan['id']) ?>" class="btn btn-success"><i class="bi bi-cash me-1"></i>Bayar</a>
        <?php endif; ?>
        <a href="<?= base_url('tagihan/pdf/' . $tagihan['id']) ?>" target="_blank" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>PDF</a>
        <a href="<?= base_url('tagihan/edit/' . $tagihan['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
        <button class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer me-1"></i>Cetak</button>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Info Tagihan -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-receipt me-2"></i>Detail Tagihan
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th width="150">No. Tagihan</th><td>: <span class="badge bg-secondary fs-6"><?= esc($tagihan['no_tagihan']) ?></span></td></tr>
                            <tr><th>Jenis Tagihan</th><td>: <span class="badge bg-info"><?= ucfirst(str_replace('_', ' ', $tagihan['jenis_tagihan'])) ?></span></td></tr>
                            <tr><th>No. Makam</th><td>: <?= esc($tagihan['no_makam']) ?></td></tr>
                            <tr><th>Nama Jenazah</th><td>: <?= esc($tagihan['nama_jenazah']) ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th width="150">Nama Keluarga</th><td>: <?= esc($tagihan['nama_keluarga']) ?></td></tr>
                            <tr><th>No. Telepon</th><td>: <?= esc($tagihan['no_telepon']) ?></td></tr>
                            <tr><th>Jatuh Tempo</th><td>: <?= date('d M Y', strtotime($tagihan['jatuh_tempo'])) ?></td></tr>
                            <tr><th>Status</th><td>: 
                                <?php
                                $statusColors = ['lunas' => 'success', 'cicilan' => 'warning', 'belum_bayar' => 'danger'];
                                $statusLabels = ['lunas' => 'Lunas', 'cicilan' => 'Cicilan', 'belum_bayar' => 'Belum Bayar'];
                                ?>
                                <span class="badge bg-<?= $statusColors[$tagihan['status']] ?? 'secondary' ?> fs-6">
                                    <?= $statusLabels[$tagihan['status']] ?? $tagihan['status'] ?>
                                </span>
                            </td></tr>
                        </table>
                    </div>
                </div>
                
            </div>
        </div>

        <!-- Rincian Item -->
        <div class="card mb-4">
            <div class="card-header bg-light"><i class="bi bi-list-ul me-2"></i>Rincian Item Tagihan</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Item / Deskripsi</th>
                            <th class="text-end" width="200">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tagihan['items'])): ?>
                            <tr>
                                <td>Biaya <?= ucfirst(str_replace('_', ' ', $tagihan['jenis_tagihan'])) ?></td>
                                <td class="text-end"><?= format_rupiah($tagihan['nominal']) ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tagihan['items'] as $item): ?>
                                <tr>
                                    <td><?= esc($item['nama_item']) ?></td>
                                    <td class="text-end"><?= format_rupiah($item['nominal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <td class="text-end">Subtotal Nominal</td>
                            <td class="text-end"><?= format_rupiah($tagihan['nominal']) ?></td>
                        </tr>
                        <?php if ($tagihan['denda'] > 0): ?>
                            <tr class="text-warning">
                                <td class="text-end">Denda</td>
                                <td class="text-end"><?= format_rupiah($tagihan['denda']) ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr class="table-primary fw-bold fs-5">
                            <td class="text-end">Total Tagihan</td>
                            <td class="text-end"><?= format_rupiah($tagihan['total']) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran</div>
            <div class="card-body p-0">
                <?php if (empty($tagihan['pembayaran'])): ?>
                    <div class="text-center text-muted py-4">Belum ada pembayaran</div>
                <?php else: ?>
                    <table class="table table-sm mb-0">
                        <thead><tr><th>No. Pembayaran</th><th>Tanggal</th><th>Metode</th><th>Nominal</th></tr></thead>
                        <tbody>
                            <?php foreach ($tagihan['pembayaran'] as $p): ?>
                                <tr>
                                    <td><?= esc($p['no_pembayaran']) ?></td>
                                    <td><?= date('d M Y H:i', strtotime($p['tanggal_bayar'])) ?></td>
                                    <td><span class="badge bg-info"><?= ucfirst($p['metode_bayar']) ?></span></td>
                                    <td class="text-success fw-bold"><?= format_rupiah($p['nominal']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h6>Total Tagihan</h6>
                <h2 class="text-primary"><?= format_rupiah($tagihan['total']) ?></h2>
                
                <?php if ($tagihan['status'] !== 'lunas'): ?>
                    <hr>
                    <h6>Sisa Pembayaran</h6>
                    <h2 class="text-danger"><?= format_rupiah($tagihan['sisa']) ?></h2>
                    <a href="<?= base_url('pembayaran/create/' . $tagihan['id']) ?>" class="btn btn-success btn-lg w-100 mt-3">
                        <i class="bi bi-cash me-2"></i>Bayar Sekarang
                    </a>
                <?php else: ?>
                    <div class="alert alert-success mb-0 mt-3">
                        <i class="bi bi-check-circle fs-1 d-block mb-2"></i>
                        LUNAS
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
