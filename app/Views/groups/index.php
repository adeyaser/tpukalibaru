<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('groups')): ?>
        <a href="<?= base_url('groups/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Group
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama Group</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groups as $g): ?>
                        <tr>
                            <td><strong><?= esc($g['nama_group']) ?></strong></td>
                            <td><?= esc($g['deskripsi'] ?: '-') ?></td>
                            <td>
                                <a href="<?= base_url('groups/permissions/' . $g['id']) ?>" class="btn btn-sm btn-primary" title="Hak Akses">
                                    <i class="bi bi-shield-check"></i>
                                </a>
                                <?php if (can_update('groups')): ?>
                                    <a href="<?= base_url('groups/edit/' . $g['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('groups')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('groups/delete/' . $g['id']) ?>', 'group <?= esc($g['nama_group']) ?>')" title="Hapus">
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
