<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-image me-2"></i><?= esc($title) ?></h4>
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
        <form action="<?= base_url('compro-settings/hero/update') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $hero['id'] ?? '' ?>">
            
            <div class="mb-3">
                <label class="form-label">Judul Utama (Headline)</label>
                <input type="text" name="judul" class="form-control form-control-lg" value="<?= esc($hero['judul'] ?? 'Solusi Pemakaman Terpercaya') ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Sub-judul (Subtitle)</label>
                <textarea name="subjudul" class="form-control" rows="2"><?= esc($hero['subjudul'] ?? 'Layanan profesional dan bermartabat untuk orang terkasih.') ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Teks Tombol (CTA)</label>
                        <input type="text" name="cta_text" class="form-control" value="<?= esc($hero['cta_text'] ?? 'Hubungi Kami') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Link Tombol</label>
                        <input type="text" name="cta_url" class="form-control" value="<?= esc($hero['cta_url'] ?? '#contact') ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Gambar Background</label>
                <input type="file" name="background_image" class="form-control" accept="image/*">
                <small class="text-muted">Rekomendasi ukuran: 1920x1080 px</small>
                <?php if (isset($hero['background_image']) && $hero['background_image']): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/compro/' . $hero['background_image']) ?>" alt="Hero BG" class="img-thumbnail" style="height: 150px">
                    </div>
                <?php endif; ?>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
