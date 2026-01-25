<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-tools me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('pembelian')): ?>
        <a href="<?= base_url('pembelian/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Tambah Data
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
                        <th>Nama Alat</th>
                        <th>Toko</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pembelian as $item): ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($item['tanggal_beli'])) ?></td>
                            <td>
                                <div class="fw-bold"><?= esc($item['nama_barang']) ?></div>
                                <small class="text-muted"><?= esc($item['no_pembelian']) ?></small>
                            </td>
                            <td><?= esc($item['supplier']) ?></td>
                            <td><?= number_format($item['jumlah']) ?></td>
                            <td>Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                            <td class="fw-bold text-primary">Rp <?= number_format($item['total_harga'], 0, ',', '.') ?></td>
                            <td>
                                <?php if ($item['bukti']): ?>
                                    <a href="<?= base_url('uploads/pembelian/' . $item['bukti']) ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-image"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (can_update('pembelian')): ?>
                                    <a href="<?= base_url('pembelian/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if (can_delete('pembelian')): ?>
                                    <button type="button" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="confirmDelete('<?= base_url('pembelian/delete/' . $item['id']) ?>')"
                                            title="Hapus">
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
