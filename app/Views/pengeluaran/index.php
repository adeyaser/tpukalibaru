<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-wallet2 me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('pengeluaran')): ?>
        <a href="<?= base_url('pengeluaran/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Pengeluaran
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No. Pengeluaran</th>
                        <th>Tanggal</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengeluaran as $p): ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?= esc($p['no_pengeluaran']) ?></span></td>
                            <td><?= date('d M Y', strtotime($p['tanggal'])) ?></td>
                            <td><span class="badge bg-info"><?= ucfirst($p['kategori']) ?></span></td>
                            <td><?= esc($p['deskripsi']) ?></td>
                            <td class="text-danger fw-bold"><?= format_rupiah($p['nominal']) ?></td>
                            <td>
                                <?php if (($p['status'] ?? 'dibayar') == 'dibayar'): ?>
                                    <span class="badge bg-success">Dibayar</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (can_update('pengeluaran')): ?>
                                    <a href="<?= base_url('pengeluaran/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if (can_delete('pengeluaran')): ?>
                                    <button class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('pengeluaran/delete/' . $p['id']) ?>')" title="Hapus">
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
