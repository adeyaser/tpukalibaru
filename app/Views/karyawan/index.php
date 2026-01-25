<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-people me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('karyawan')): ?>
        <a href="<?= base_url('karyawan/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Karyawan
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>No. Telepon</th>
                        <th>Tgl Masuk</th>
                        <th>Gaji Pokok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($karyawan as $k): ?>
                        <tr>
                            <td><span class="badge bg-primary"><?= esc($k['nip']) ?></span></td>
                            <td>
                                <a href="<?= base_url('karyawan/view/' . $k['id']) ?>" class="text-decoration-none fw-bold">
                                    <?= esc($k['nama_lengkap']) ?>
                                </a>
                            </td>
                            <td><?= esc($k['jabatan']) ?></td>
                            <td><?= esc($k['no_telepon'] ?: '-') ?></td>
                            <td><?= date('d M Y', strtotime($k['tanggal_masuk'])) ?></td>
                            <td><?= format_rupiah($k['gaji_pokok']) ?></td>
                            <td>
                                <span class="badge bg-<?= $k['status'] == 'aktif' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($k['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('karyawan/view/' . $k['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (can_update('karyawan')): ?>
                                    <a href="<?= base_url('karyawan/edit/' . $k['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
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
