<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('users/update/' . $user['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control" value="<?= old('username', $user['username']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $user['nama_lengkap']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                        <input type="password" name="password" class="form-control" minlength="6">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Group <span class="text-danger">*</span></label>
                        <?php foreach ($groups as $g): ?>
                            <div class="form-check">
                                <input type="checkbox" name="groups[]" value="<?= $g['id'] ?>" class="form-check-input" id="g<?= $g['id'] ?>" <?= in_array($g['id'], $user['group_ids']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="g<?= $g['id'] ?>"><?= esc($g['nama_group']) ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= old('status', $user['status']) == 'active' ? 'selected' : '' ?>>Aktif</option>
                            <option value="inactive" <?= old('status', $user['status']) == 'inactive' ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <?php if ($user['foto']): ?>
                            <small class="text-muted">Foto saat ini: <?= esc($user['foto']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('users') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
