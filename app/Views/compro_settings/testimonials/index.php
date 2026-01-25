<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-chat-quote me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
         <a href="<?= base_url('compro-settings') ?>" class="btn btn-secondary">Kembali</a>
         <a href="<?= base_url('compro-settings/testimonials/create') ?>" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Tambah Testimoni</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row">
    <?php if (empty($testimonials)): ?>
        <div class="col-12">
            <div class="alert alert-secondary text-center">Belum ada testimoni</div>
        </div>
    <?php else: ?>
        <?php foreach ($testimonials as $t): ?>
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?= $t['foto'] ? base_url('uploads/compro/' . $t['foto']) : base_url('assets/img/avatar.png') ?>" class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                            <div>
                                <h6 class="mb-0"><?= esc($t['nama']) ?></h6>
                                <small class="text-muted"><?= esc($t['relasi']) ?></small>
                            </div>
                            <div class="ms-auto text-warning">
                                <?php for($i=0; $i<$t['rating']; $i++): ?><i class="bi bi-star-fill"></i><?php endfor; ?>
                            </div>
                        </div>
                        <p class="card-text fst-italic">"<?= esc($t['testimoni']) ?>"</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-end gap-2">
                        <a href="<?= base_url('compro-settings/testimonials/edit/' . $t['id']) ?>" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('compro-settings/testimonials/delete/' . $t['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus testimoni ini?')"><i class="bi bi-trash"></i></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>
