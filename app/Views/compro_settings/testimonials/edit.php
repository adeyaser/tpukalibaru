<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('compro-settings/testimonials/update/' . $testimonial['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= esc($testimonial['name']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Peran / Jabatan</label>
                        <input type="text" name="role" class="form-control" value="<?= esc($testimonial['role']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="rating-input">
                    <?php for($i=5; $i>=1; $i--): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="r<?= $i ?>" value="<?= $i ?>" <?= $testimonial['rating'] == $i ? 'checked' : '' ?>>
                            <label class="form-check-label" for="r<?= $i ?>"><?= str_repeat('⭐', $i) ?> (<?= $i ?>)</label>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Isi Testimoni <span class="text-danger">*</span></label>
                <textarea name="content" class="form-control" rows="3" required><?= esc($testimonial['content']) ?></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Foto Avatar (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="avatar" class="form-control" accept="image/*">
                <?php if ($testimonial['avatar']): ?>
                    <div class="mt-2">
                        <img src="<?= base_url('uploads/compro/' . $testimonial['avatar']) ?>" alt="Avatar" class="img-thumbnail" style="height: 80px">
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('compro-settings/testimonials') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
