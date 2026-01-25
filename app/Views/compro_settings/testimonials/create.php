<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('compro-settings/testimonials/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Peran / Jabatan</label>
                        <input type="text" name="role" class="form-control" placeholder="Contoh: Keluarga Alm. Bpk. Budi">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="rating-input">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="r5" value="5" checked>
                        <label class="form-check-label" for="r5">⭐⭐⭐⭐⭐ (5)</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="rating" id="r4" value="4">
                        <label class="form-check-label" for="r4">⭐⭐⭐⭐ (4)</label>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Isi Testimoni <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto Avatar (Opsional)</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="<?= base_url('compro-settings/testimonials') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
