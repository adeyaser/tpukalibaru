<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-geo-alt me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('lokasi-makam')): ?>
        <a href="<?= base_url('lokasi-makam/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Lokasi
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Kode Blok</th>
                        <th>Nama Blok</th>
                        <th>Kapasitas</th>
                        <th>Terisi</th>
                        <th>Tersedia</th>
                        <th>Harga Sewa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lokasi as $l): ?>
                        <tr>
                            <td><span class="badge bg-primary"><?= esc($l['kode_blok']) ?></span></td>
                            <td><?= esc($l['nama_blok']) ?></td>
                            <td><?= number_format($l['kapasitas']) ?></td>
                            <td><?= number_format($l['terisi']) ?></td>
                            <td>
                                <?php $tersedia = $l['kapasitas'] - $l['terisi']; ?>
                                <span class="badge <?= $tersedia > 0 ? 'bg-success' : 'bg-danger' ?>">
                                    <?= number_format($tersedia) ?>
                                </span>
                            </td>
                            <td><?= format_rupiah($l['harga_sewa']) ?></td>
                            <td>
                                <?php if (can_update('lokasi-makam')): ?>
                                    <a href="<?= base_url('lokasi-makam/edit/' . $l['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('lokasi-makam') && $l['terisi'] == 0): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('lokasi-makam/delete/' . $l['id']) ?>', 'lokasi ini')" title="Hapus">
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
