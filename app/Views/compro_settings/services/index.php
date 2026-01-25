<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-grid-3x3-gap me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
         <a href="<?= base_url('compro-settings') ?>" class="btn btn-secondary">Kembali</a>
         <a href="<?= base_url('compro-settings/services/create') ?>" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Tambah Layanan</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th width="50">No</th>
                    <th width="50">Icon</th>
                    <th>Judul Layanan</th>
                    <th>Deskripsi</th>
                    <th>Urutan</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($services)): ?>
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada layanan</td></tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($services as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td class="fs-4"><i class="<?= esc($s['icon']) ?>"></i></td>
                            <td><strong><?= esc($s['nama_layanan']) ?></strong></td>
                            <td><?= esc(substr($s['deskripsi'], 0, 50)) ?>...</td>
                            <td><?= $s['urutan'] ?></td>
                            <td class="text-end">
                                <a href="<?= base_url('compro-settings/services/edit/' . $s['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                                <a href="<?= base_url('compro-settings/services/delete/' . $s['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus layanan ini?')"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= $this->endSection() ?>
