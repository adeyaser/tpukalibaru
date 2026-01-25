<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('keluarga/store') ?>" method="POST">
            <?= csrf_field() ?>
            <?php if (isset($jenazah) && $jenazah): ?>
                <input type="hidden" name="jenazah_id" value="<?= esc($jenazah['id']) ?>">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Menambahkan data keluarga untuk: <strong><?= esc($jenazah['nama_lengkap']) ?></strong>
                </div>
            <?php else: ?>
                <div class="mb-4">
                    <label class="form-label">Pilih Jenazah <span class="text-danger">*</span></label>
                    <select name="jenazah_id" class="form-control select2" required>
                        <option value="">-- Pilih Jenazah --</option>
                        <?php if (isset($daftar_jenazah)): ?>
                            <?php foreach ($daftar_jenazah as $j): ?>
                                <option value="<?= $j['id'] ?>"><?= esc($j['nama_lengkap']) ?> (NIK: <?= esc($j['nik']) ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="<?= old('nama_lengkap') ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Hubungan <span class="text-danger">*</span></label>
                        <select name="hubungan" class="form-select" required>
                            <option value="">Pilih Hubungan</option>
                            <?php foreach (['Suami', 'Istri', 'Anak', 'Ayah', 'Ibu', 'Saudara', 'Keponakan', 'Cucu', 'Lainnya'] as $h): ?>
                                <option value="<?= $h ?>" <?= old('hubungan') == $h ? 'selected' : '' ?>><?= $h ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="<?= old('nik') ?>" maxlength="16">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" class="form-control" value="<?= old('no_telepon') ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= old('email') ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2"><?= old('alamat') ?></textarea>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_penanggung_jawab" value="1" class="form-check-input" id="pj" <?= old('is_penanggung_jawab') ? 'checked' : '' ?>>
                    <label class="form-check-label" for="pj">
                        <strong>Penanggung Jawab</strong> (akan ditagihkan untuk biaya pemakaman)
                    </label>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="<?= (isset($jenazah) && $jenazah) ? base_url('jenazah/view/' . $jenazah['id']) : base_url('keluarga') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
