<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person-gear me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('users')): ?>
        <a href="<?= base_url('users/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah User
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Groups</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <?php if ($u['foto']): ?>
                                    <img src="<?= base_url('uploads/users/' . $u['foto']) ?>" class="rounded-circle me-2" style="width: 32px; height: 32px; object-fit: cover;">
                                <?php endif; ?>
                                <strong><?= esc($u['username']) ?></strong>
                            </td>
                            <td><?= esc($u['nama_lengkap']) ?></td>
                            <td><?= esc($u['email']) ?></td>
                            <td>
                                <?php foreach ($u['groups'] as $g): ?>
                                    <span class="badge bg-secondary"><?= esc($g) ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $u['status'] == 'active' ? 'success' : 'danger' ?>">
                                    <?= $u['status'] == 'active' ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td>
                                <?php if (can_update('users')): ?>
                                    <a href="<?= base_url('users/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('users') && $u['id'] != session()->get('userId')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('users/delete/' . $u['id']) ?>', 'user <?= esc($u['username']) ?>')" title="Hapus">
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
