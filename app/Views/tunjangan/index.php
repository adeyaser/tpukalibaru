<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-award me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('tunjangan')): ?>
        <a href="<?= base_url('tunjangan/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Tunjangan
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama Tunjangan</th>
                        <th>Nominal</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tunjangan as $t): ?>
                        <tr>
                            <td><strong><?= esc($t['nama_tunjangan']) ?></strong></td>
                            <td class="text-success"><?= format_rupiah($t['nominal']) ?></td>
                            <td><?= esc($t['deskripsi'] ?: '-') ?></td>
                            <td>
                                <span class="badge bg-<?= $t['is_active'] ? 'success' : 'secondary' ?>">
                                    <?= $t['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td>
                                <?php if (can_update('tunjangan')): ?>
                                    <a href="<?= base_url('tunjangan/edit/' . $t['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('tunjangan')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('tunjangan/delete/' . $t['id']) ?>')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
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
