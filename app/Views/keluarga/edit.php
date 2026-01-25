<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('keluarga/update/' . $keluarga['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-1"></i>
                Mengedit data keluarga untuk: <strong><?= esc($jenazah['nama_lengkap']) ?></strong>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap', $keluarga['nama_lengkap']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                        <select name="hubungan" class="form-select" required>
                            <?php foreach (['Suami', 'Istri', 'Anak', 'Ayah', 'Ibu', 'Saudara', 'Keponakan', 'Cucu', 'Lainnya'] as $h): ?>
                                <option value="<?= $h ?>" <?= old('hubungan', $keluarga['hubungan']) == $h ? 'selected' : '' ?>><?= $h ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= old('nik', $keluarga['nik']) ?>" maxlength="16">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon', $keluarga['no_telepon']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $keluarga['email']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= old('alamat', $keluarga['alamat']) ?></textarea>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_penanggung_jawab" value="1" class="form-check-input" id="pj" <?= old('is_penanggung_jawab', $keluarga['is_penanggung_jawab']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pj">
                        <strong>Penanggung Jawab</strong>
                    </label>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('jenazah/view/' . $keluarga['jenazah_id']) ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
