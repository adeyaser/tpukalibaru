<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-images me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
         <a href="<?= base_url('compro-settings') ?>" class="btn btn-secondary">Kembali</a>
         <a href="<?= base_url('compro-settings/gallery/create') ?>" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Tambah Foto</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php if (empty($gallery)): ?>
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada foto galeri</div>
        </div>
    <?php else: ?>
        <?php foreach ($gallery as $foto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?= base_url('uploads/compro/' . $foto['gambar']) ?>" class="card-img-top" alt="<?= esc($foto['judul']) ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?= esc($foto['judul']) ?></h5>
                        <p class="card-text text-muted small"><?= esc($foto['deskripsi']) ?></p>
                        <a href="<?= base_url('compro-settings/gallery/delete/' . $foto['id']) ?>" class="btn btn-sm btn-outline-danger w-100" onclick="return confirm('Hapus foto ini?')">
                            <i class="bi bi-trash me-1"></i>Hapus
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
