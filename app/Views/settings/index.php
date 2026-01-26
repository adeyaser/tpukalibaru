<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-gear me-2"></i><?= esc($title) ?></h4>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('settings/update') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-12">
                     <div class="mb-3">
                        <label class="form-label">Logo Website</label>
                        <input type="file" name="site_logo" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG. Maks: 2MB.</small>
                        <?php if (!empty($settings['site_logo'])): ?>
                            <div class="mt-2">
                                <p class="mb-1 text-sm text-muted">Logo saat ini:</p>
                                <img src="<?= base_url('uploads/settings/' . $settings['site_logo']) ?>" alt="Logo" style="max-height: 80px; width: auto;" class="border rounded p-1 bg-light">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Website</label>
                        <input type="text" name="site_title" class="form-control" value="<?= esc($settings['site_title'] ?? 'SI-MAKAM') ?>">
                        <small class="text-muted">Digunakan untuk title tag dan meta</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama TPU</label>
                        <input type="text" name="nama_tpu" class="form-control" value="<?= esc($settings['nama_tpu'] ?? '') ?>" placeholder="Contoh: TPU KALIBARU MEDAN SATRIA">
                        <small class="text-muted">Ditampilkan di navbar dan footer</small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Warna Tema (Hex Code)</label>
                        <input type="color" name="theme_color" class="form-control form-control-color" value="<?= esc($settings['theme_color'] ?? '#0D6EFD') ?>" title="Choose your color">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi Singkat</label>
                <textarea name="site_description" class="form-control" rows="2"><?= esc($settings['site_description'] ?? '') ?></textarea>
            </div>
            
            <hr>
            <h6>Informasi Kantor</h6>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="site_email" class="form-control" value="<?= esc($settings['site_email'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. Telepon</label>
                        <input type="text" name="site_phone" class="form-control" value="<?= esc($settings['site_phone'] ?? '') ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="site_address" class="form-control" rows="2"><?= esc($settings['site_address'] ?? '') ?></textarea>
            </div>
            
            <hr>
            

            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Pengaturan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
