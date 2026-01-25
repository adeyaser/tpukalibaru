<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-tree me-2"></i><?= esc($title) ?></h4>
    <?php if (can_create('pemakaman')): ?>
        <a href="<?= base_url('pemakaman/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>Proses Pemakaman
        </a>
    <?php endif; ?>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No. Makam</th>
                        <th>Nama Jenazah</th>
                        <th>Lokasi</th>
                        <th>Tgl Pemakaman</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pemakaman as $p): ?>
                        <tr>
                            <td><span class="badge bg-primary"><?= esc($p['no_makam']) ?></span></td>
                            <td>
                                <a href="<?= base_url('pemakaman/view/' . $p['id']) ?>" class="text-decoration-none fw-bold">
                                    <?= esc($p['nama_jenazah']) ?>
                                </a>
                            </td>
                            <td><?= esc($p['nama_blok']) ?> (<?= esc($p['kode_blok']) ?>)</td>
                            <td><?= date('d M Y', strtotime($p['tanggal_pemakaman'])) ?></td>
                            <td>
                                <?php if ($p['masa_berlaku']): ?>
                                    <?php $expired = strtotime($p['masa_berlaku']) < time(); ?>
                                    <span class="<?= $expired ? 'text-danger' : '' ?>">
                                        <?= date('d M Y', strtotime($p['masa_berlaku'])) ?>
                                    </span>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $p['status'] == 'aktif' ? 'success' : ($p['status'] == 'kadaluarsa' ? 'warning' : 'secondary') ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= base_url('pemakaman/view/' . $p['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <?php if (can_update('pemakaman')): ?>
                                    <a href="<?= base_url('pemakaman/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
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
