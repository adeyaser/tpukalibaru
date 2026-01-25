<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person-badge me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <?php if (!isset($jenazah['pemakaman']) && can_create('pemakaman')): ?>
            <a href="<?= base_url('pemakaman/create?jenazah_id=' . $jenazah['id']) ?>" class="btn btn-success">
                <i class="bi bi-tree me-1"></i>Proses Pemakaman
            </a>
        <?php endif; ?>
        <a href="<?= base_url('keluarga/create/' . $jenazah['id']) ?>" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i>Tambah Keluarga
        </a>
        <a href="<?= base_url('jenazah/edit/' . $jenazah['id']) ?>" class="btn btn-warning">
            <i class="bi bi-pencil me-1"></i>Edit
        </a>
    </div>
</div>

<div class="row">
    <!-- Info Jenazah -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Informasi Jenazah
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        <?php if ($jenazah['foto']): ?>
                            <img src="<?= base_url('uploads/jenazah/' . $jenazah['foto']) ?>" class="rounded" style="max-width: 150px;">
                        <?php else: ?>
                            <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center" style="width: 150px; height: 150px; font-size: 48px;">
                                <i class="bi bi-person"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr><th width="150">NIK</th><td>: <?= esc($jenazah['nik'] ?: '-') ?></td></tr>
                            <tr><th>Nama Lengkap</th><td>: <?= esc($jenazah['nama_lengkap']) ?></td></tr>
                            <tr><th>TTL</th><td>: <?= esc($jenazah['tempat_lahir'] ?: '-') ?>, <?= $jenazah['tanggal_lahir'] ? date('d M Y', strtotime($jenazah['tanggal_lahir'])) : '-' ?></td></tr>
                            <tr><th>Tanggal Wafat</th><td>: <span class="text-danger fw-bold"><?= date('d M Y', strtotime($jenazah['tanggal_wafat'])) ?></span></td></tr>
                            <tr><th>Jenis Kelamin</th><td>: <?= $jenazah['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td></tr>
                            <tr><th>Agama</th><td>: <?= esc($jenazah['agama']) ?></td></tr>
                            <tr><th>Alamat</th><td>: <?= esc($jenazah['alamat'] ?: '-') ?></td></tr>
                            <tr><th>Penyebab Kematian</th><td>: <?= esc($jenazah['penyebab_kematian'] ?: '-') ?></td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Pemakaman -->
        <?php if (isset($jenazah['pemakaman']) && $jenazah['pemakaman']): ?>
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-tree me-2"></i>Informasi Pemakaman
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><th width="150">No. Makam</th><td>: <span class="badge bg-primary fs-6"><?= esc($jenazah['pemakaman']['no_makam']) ?></span></td></tr>
                                <tr><th>Lokasi</th><td>: <?= esc($jenazah['pemakaman']['nama_blok']) ?> (<?= esc($jenazah['pemakaman']['kode_blok']) ?>)</td></tr>
                                <tr><th>Baris / Nomor</th><td>: <?= esc($jenazah['pemakaman']['baris'] ?? '-') ?> / <?= esc($jenazah['pemakaman']['nomor'] ?? '-') ?></td></tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr><th width="150">Tgl Pemakaman</th><td>: <?= date('d M Y H:i', strtotime($jenazah['pemakaman']['tanggal_pemakaman'])) ?></td></tr>
                                <tr><th>Masa Berlaku</th><td>: <?= $jenazah['pemakaman']['masa_berlaku'] ? date('d M Y', strtotime($jenazah['pemakaman']['masa_berlaku'])) : '-' ?></td></tr>
                                <tr><th>Status</th><td>: <span class="badge bg-<?= $jenazah['pemakaman']['status'] == 'aktif' ? 'success' : 'warning' ?>"><?= ucfirst($jenazah['pemakaman']['status']) ?></span></td></tr>
                            </table>
                        </div>
                    </div>
                    <a href="<?= base_url('pemakaman/view/' . $jenazah['pemakaman']['id']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-eye me-1"></i>Lihat Detail Pemakaman
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Data Keluarga -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-people me-2"></i>Data Keluarga</span>
                <a href="<?= base_url('keluarga/create/' . $jenazah['id']) ?>" class="btn btn-sm btn-light">
                    <i class="bi bi-plus"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <?php if (empty($jenazah['keluarga'])): ?>
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                        Belum ada data keluarga
                    </div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($jenazah['keluarga'] as $k): ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">
                                            <?= esc($k['nama_lengkap']) ?>
                                            <?php if ($k['is_penanggung_jawab']): ?>
                                                <span class="badge bg-primary ms-1">PJ</span>
                                            <?php endif; ?>
                                        </h6>
                                        <small class="text-muted">
                                            <?= esc($k['hubungan']) ?><br>
                                            <i class="bi bi-telephone"></i> <?= esc($k['no_telepon']) ?>
                                        </small>
                                    </div>
                                    <div>
                                        <a href="<?= base_url('keluarga/edit/' . $k['id']) ?>" class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
