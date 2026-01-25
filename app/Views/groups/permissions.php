<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-shield-check me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('groups/save-permissions/' . $group['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Menu</th>
                            <th class="text-center" width="100">View</th>
                            <th class="text-center" width="100">Create</th>
                            <th class="text-center" width="100">Update</th>
                            <th class="text-center" width="100">Delete</th>
                            <th class="text-center" width="100">All</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $menu): ?>
                            <?php $perm = $permissions[$menu['id']] ?? ['can_view' => 0, 'can_create' => 0, 'can_update' => 0, 'can_delete' => 0]; ?>
                            <tr class="<?= $menu['parent_id'] ? 'bg-light' : '' ?>">
                                <td>
                                    <?php if ($menu['parent_id']): ?>&nbsp;&nbsp;&nbsp;↳ <?php endif; ?>
                                    <i class="bi <?= esc($menu['icon'] ?: 'bi-circle') ?> me-1"></i>
                                    <?= esc($menu['nama_menu']) ?>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input perm-check" name="menus[<?= $menu['id'] ?>][view]" value="1" <?= $perm['can_view'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input perm-check" name="menus[<?= $menu['id'] ?>][create]" value="1" <?= $perm['can_create'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input perm-check" name="menus[<?= $menu['id'] ?>][update]" value="1" <?= $perm['can_update'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input perm-check" name="menus[<?= $menu['id'] ?>][delete]" value="1" <?= $perm['can_delete'] ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" class="form-check-input check-all" data-menu="<?= $menu['id'] ?>">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan Hak Akses</button>
                <a href="<?= base_url('groups') ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.querySelectorAll('.check-all').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const menuId = this.dataset.menu;
        const row = this.closest('tr');
        row.querySelectorAll('.perm-check').forEach(cb => cb.checked = this.checked);
    });
});
</script>
<?= $this->endSection() ?>
