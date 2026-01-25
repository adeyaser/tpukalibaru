<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('jenazah')): ?>
        <a href="<?= base_url('jenazah/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Data
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Wafat</th>
                        <th>Agama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jenazah as $j): ?>
                        <tr>
                            <td><?= esc($j['nik'] ?: '-') ?></td>
                            <td>
                                <a href="<?= base_url('jenazah/view/' . $j['id']) ?>" class="text-decoration-none fw-bold">
                                    <?= esc($j['nama_lengkap']) ?>
                                </a>
                            </td>
                            <td>
                                <span class="badge <?= $j['jenis_kelamin'] == 'L' ? 'bg-primary' : 'bg-info' ?>">
                                    <?= $j['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                                </span>
                            </td>
                            <td><?= date('d M Y', strtotime($j['tanggal_wafat'])) ?></td>
                            <td><?= esc($j['agama']) ?></td>
                            <td>
                                <?php
                                $db = \Config\Database::connect();
                                $hasBurial = $db->table('pemakaman')->where('jenazah_id', $j['id'])->countAllResults() > 0;
                                ?>
                                <span class="badge <?= $hasBurial ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $hasBurial ? 'Sudah Dimakamkan' : 'Belum Dimakamkan' ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('jenazah/view/' . $j['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (can_update('jenazah')): ?>
                                    <a href="<?= base_url('jenazah/edit/' . $j['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
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
