<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cash-stack me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover datatable">
                <thead>
                    <tr>
                        <th>No. Pembayaran</th>
                        <th>Tanggal</th>
                        <th>No. Tagihan</th>
                        <th>Nama Jenazah</th>
                        <th>Metode</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pembayaran as $p): ?>
                        <tr>
                            <td><span class="badge bg-success"><?= esc($p['no_pembayaran']) ?></span></td>
                            <td><?= date('d M Y H:i', strtotime($p['tanggal_bayar'])) ?></td>
                            <td><?= esc($p['no_tagihan']) ?></td>
                            <td><?= esc($p['nama_jenazah']) ?></td>
                            <td><span class="badge bg-info"><?= ucfirst($p['metode_bayar']) ?></span></td>
                            <td class="text-success fw-bold"><?= format_rupiah($p['nominal']) ?></td>
                            <td>
                                <a href="<?= base_url('pembayaran/view/' . $p['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
