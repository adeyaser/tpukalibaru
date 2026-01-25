<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-list-ul me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('menus')): ?>
        <a href="<?= base_url('menus/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Menu
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Urutan</th>
                        <th>Icon</th>
                        <th>Nama Menu</th>
                        <th>URL</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $m): ?>
                        <tr class="<?= $m['parent_id'] ? 'bg-light' : '' ?>">
                            <td><?= $m['urutan'] ?></td>
                            <td>
                                <?php 
                                $iconClass = $m['icon'] ?: 'bi-circle';
                                $iconPrefix = str_starts_with($iconClass, 'fa') ? '' : 'bi';
                                $finalIconClass = $iconPrefix ? "$iconPrefix $iconClass" : $iconClass;
                                ?>
                                <i class="<?= $finalIconClass ?> fs-5"></i>
                            </td>
                            <td>
                                <?php if ($m['parent_id']): ?>&nbsp;&nbsp;↳ <?php endif; ?>
                                <strong><?= esc($m['nama_menu']) ?></strong>
                            </td>
                            <td><code><?= esc($m['url'] ?: '-') ?></code></td>
                            <td>
                                <?php if ($m['parent_id']): ?>
                                    <?php 
                                    $parent = array_filter($menus, fn($x) => $x['id'] == $m['parent_id']);
                                    $parent = reset($parent);
                                    echo esc($parent['nama_menu'] ?? '-');
                                    ?>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $m['is_active'] ? 'success' : 'secondary' ?>">
                                    <?= $m['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                            </td>
                            <td>
                                <?php if (can_update('menus')): ?>
                                    <a href="<?= base_url('menus/edit/' . $m['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('menus')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('menus/delete/' . $m['id']) ?>')" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
