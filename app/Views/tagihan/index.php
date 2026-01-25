<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-receipt me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('tagihan')): ?>
        <a href="<?= base_url('tagihan/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Buat Tagihan
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No. Tagihan</th>
                        <th>Nama Jenazah</th>
                        <th>Keluarga</th>
                        <th>Jenis</th>
                        <th>Total</th>
                        <th>Sisa</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tagihan as $t): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= esc($t['no_tagihan']) ?></span></td>
                            <td><?= esc($t['nama_jenazah']) ?></td>
                            <td>
                                <?= esc($t['nama_keluarga']) ?><br>
                                <small class="text-muted"><?= esc($t['no_telepon']) ?></small>
                            </td>
                            <td><span class="badge bg-info"><?= ucfirst(str_replace('_', ' ', $t['jenis_tagihan'])) ?></span></td>
                            <td><?= format_rupiah($t['total']) ?></td>
                            <td class="<?= $t['sisa'] > 0 ? 'text-danger fw-bold' : 'text-success' ?>">
                                <?= format_rupiah($t['sisa']) ?>
                            </td>
                            <td>
                                <?php 
                                $expired = strtotime($t['jatuh_tempo']) < time() && $t['status'] !== 'lunas';
                                ?>
                                <span class="<?= $expired ? 'text-danger fw-bold' : '' ?>">
                                    <?= date('d M Y', strtotime($t['jatuh_tempo'])) ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $statusColors = [
                                    'lunas' => 'success',
                                    'cicilan' => 'warning',
                                    'belum_bayar' => 'danger',
                                ];
                                $statusLabels = [
                                    'lunas' => 'Lunas',
                                    'cicilan' => 'Cicilan',
                                    'belum_bayar' => 'Belum Bayar',
                                ];
                                ?>
                                <span class="badge bg-<?= $statusColors[$t['status']] ?? 'secondary' ?>">
                                    <?= $statusLabels[$t['status']] ?? $t['status'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('tagihan/view/' . $t['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if ($t['status'] !== 'lunas'): ?>
                                    <a href="<?= base_url('pembayaran/create/' . $t['id']) ?>" class="btn btn-sm btn-success" title="Bayar">
                                        <i class="bi bi-cash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
