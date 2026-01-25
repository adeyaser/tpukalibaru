<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('compro-settings/services/update/' . $service['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Judul Layanan <span class="text-danger">*</span></label>
                <input type="text" name="nama_layanan" class="form-control" value="<?= esc($service['nama_layanan']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= esc($service['deskripsi']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Icon (Klik untuk memilih)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="<?= esc($service['icon']) ?>"></i></span>
                            <input type="text" name="icon" class="form-control" value="<?= esc($service['icon']) ?>" readonly style="cursor: pointer;">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil</label>
                        <input type="number" name="urutan" class="form-control" value="<?= esc($service['urutan']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('compro-settings/services') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->include('partials/icon_picker') ?>
<?= $this->endSection() ?>
