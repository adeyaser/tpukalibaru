<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-info-circle me-2"></i><?= esc($title) ?></h4>
    <a href="<?= base_url('compro-settings') ?>" class="btn btn-secondary">Kembali</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('compro-settings/about/update') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $about['id'] ?? '' ?>">
            
            <div class="mb-3">
                <label class="form-label">Judul Bagian</label>
                <input type="text" name="judul" class="form-control" value="<?= esc($about['judul'] ?? 'Tentang TPU Kami') ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi Lengkap</label>
                <textarea name="deskripsi" class="form-control" rows="5"><?= esc($about['deskripsi'] ?? '') ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Visi</label>
                        <textarea name="visi" class="form-control" rows="3"><?= esc($about['visi'] ?? '') ?></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Misi</label>
                        <textarea name="misi" class="form-control" rows="3"><?= esc($about['misi'] ?? '') ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto Ilustrasi</label>
                <input type="file" name="gambar" class="form-control" accept="image/*">
                <?php if (isset($about['gambar'])): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/compro/' . $about['gambar']) ?>" alt="About Image" class="img-thumbnail" style="height: 150px">
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
