<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-telephone me-2"></i><?= esc($title) ?></h4>
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
        <form action="<?= base_url('compro-settings/contact/update') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= $contact['id'] ?? '' ?>">
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= esc($contact['email'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">No. Telepon / WhatsApp</label>
                        <input type="text" name="phone" class="form-control" value="<?= esc($contact['phone'] ?? '') ?>">
                    </div>
                </div>
            </div>
            
             <div class="mb-3">
                <label class="form-label">Jam Operasional</label>
                <input type="text" name="working_hours" class="form-control" value="<?= esc($contact['working_hours'] ?? 'Senin - Minggu: 08:00 - 16:00') ?>">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="address" class="form-control" rows="3"><?= esc($contact['address'] ?? '') ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Embed Google Maps (Iframe)</label>
                <textarea name="maps_embed" class="form-control" rows="4" placeholder='<iframe src="https://www.google.com/maps/embed...'> <?= esc($contact['maps_embed'] ?? '') ?></textarea>
                <small class="text-muted">Copy kode embed (iframe) dari Google Maps dan paste di sini.</small>
            </div>
            
            <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Perubahan</button>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
