<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('menus/update/' . $menu['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select name="parent_id" class="form-select">
                            <option value="0" <?= $menu['parent_id'] == 0 ? 'selected' : '' ?>>ROOT (Menu Utama)</option>
                            <?php foreach ($parents as $p): ?>
                                <?php if ($p['id'] != $menu['id']): // Prevent selecting self as parent ?>
                                    <option value="<?= $p['id'] ?>" <?= $menu['parent_id'] == $p['id'] ? 'selected' : '' ?>>
                                        <?= esc($p['nama_menu']) ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Judul Menu <span class="text-danger">*</span></label>
                        <input type="text" name="nama_menu" class="form-control" value="<?= old('nama_menu', $menu['nama_menu']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">URL/Link <span class="text-danger">*</span></label>
                        <input type="text" name="url" class="form-control" value="<?= old('url', $menu['url']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Icon (Klik untuk memilih)</label>
                        <div class="input-group">
                             <span class="input-group-text"><i class="<?= old('icon', $menu['icon']) ?>"></i></span>
                             <input type="text" name="icon" class="form-control" value="<?= old('icon', $menu['icon']) ?>" readonly style="cursor: pointer;">
                        </div>
                        <small class="text-muted">Support <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a> & <a href="https://fontawesome.com/search" target="_blank">Font Awesome</a></small>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="number" name="urutan" class="form-control" value="<?= old('urutan', $menu['urutan']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= old('is_active', $menu['is_active']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_active">Status Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('menus') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->include('partials/icon_picker') ?>
<?= $this->endSection() ?>
