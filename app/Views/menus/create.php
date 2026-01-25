<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('menus/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select name="parent_id" class="form-select">
                            <option value="0">ROOT (Menu Utama)</option>
                            <?php foreach ($parents as $p): ?>
                                <option value="<?= $p['id'] ?>">
                                    <?= esc($p['nama_menu']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Judul Menu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_menu" class="form-control" value="<?= old('nama_menu') ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">URL/Link <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" value="<?= old('url') ?>" required>
                        <small class="text-muted">Gunakan '#' untuk menu parent yang tidak punya link</small>
                    </div>
                </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Klik untuk memilih)</label>
                        <div class="input-group">
                             <span class="input-group-text"><i class="bi bi-search"></i></span>
                             <input type="text" name="icon" class="form-control" value="<?= old('icon') ?>" placeholder="Pilih icon..." readonly style="cursor: pointer;">
                        </div>
                        <small class="text-muted">Support <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> & <a href="https://fontawesome.com/search" target="_blank">Font Awesome</a></small>
                    </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="<?= old('urutan', 0) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Status Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="<?= base_url('menus') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->include('partials/icon_picker') ?>
<?= $this->endSection() ?>
