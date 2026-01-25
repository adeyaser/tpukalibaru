<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-wrench me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('perawatan')): ?>
        <a href="<?= base_url('perawatan/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Perawatan
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Makam</th>
                        <th>Nama Jenazah</th>
                        <th>Jenis</th>
                        <th>Biaya</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($perawatan as $p): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($p['tanggal_perawatan'])) ?></td>
                            <td><span class="badge bg-primary"><?= esc($p['no_makam']) ?></span></td>
                            <td><?= esc($p['nama_lengkap']) ?></td>
                            <td><span class="badge bg-info"><?= ucfirst($p['jenis_perawatan']) ?></span></td>
                            <td><?= format_rupiah($p['biaya']) ?></td>
                            <td>
                                <span class="badge bg-<?= $p['status'] == 'selesai' ? 'success' : 'warning' ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if (can_update('perawatan')): ?>
                                    <a href="<?= base_url('perawatan/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('perawatan')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('perawatan/delete/' . $p['id']) ?>')" title="Hapus">
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
