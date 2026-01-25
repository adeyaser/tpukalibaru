<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cash-coin me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('gaji')): ?>
        <a href="<?= base_url('gaji/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Buat Slip Gaji
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>NIP</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>Gaji Bersih</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach ($gaji as $g): ?>
                        <tr>
                            <td><?= date('F Y', strtotime($g['periode'] . '-01')) ?></td>
                            <td><span class="badge bg-secondary"><?= esc($g['nip']) ?></span></td>
                            <td><?= esc($g['nama_lengkap']) ?></td>
                            <td><?= esc($g['jabatan']) ?></td>
                            <td class="fw-bold"><?= format_rupiah($g['total_gaji']) ?></td>
                            <td>
                                <span class="badge bg-<?= $g['status'] == 'dibayar' ? 'success' : 'warning' ?>">
                                    <?= ucfirst($g['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('gaji/view/' . $g['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if ($g['status'] !== 'dibayar' && can_update('gaji')): ?>
                                    <a href="<?= base_url('gaji/bayar/' . $g['id']) ?>" class="btn btn-sm btn-success" title="Bayar" onclick="return confirm('Proses pembayaran gaji?')">
                                        <i class="bi bi-check-lg"></i>
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
