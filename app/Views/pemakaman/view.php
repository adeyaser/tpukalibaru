<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-tree me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <a href="<?= base_url('pemakaman/edit/' . $pemakaman['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="<?= base_url('perawatan/create?pemakaman_id=' . $pemakaman['id']) ?>" class="btn btn-info"><i class="bi bi-wrench me-1"></i>Tambah Perawatan</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Info Pemakaman -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <i class="bi bi-tree me-2"></i>Informasi Pemakaman
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th width="150">No. Makam</th><td>: <span class="badge bg-primary fs-6"><?= esc($pemakaman['no_makam']) ?></span></td></tr>
                            <tr><th>Nama Jenazah</th><td>: <strong><?= esc($pemakaman['nama_jenazah']) ?></strong></td></tr>
                            <tr><th>NIK</th><td>: <?= esc($pemakaman['nik'] ?: '-') ?></td></tr>
                            <tr><th>Jenis Kelamin</th><td>: <?= $pemakaman['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td></tr>
                            <tr><th>Agama</th><td>: <?= esc($pemakaman['agama']) ?></td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr><th width="150">Lokasi</th><td>: <?= esc($pemakaman['nama_blok']) ?> (<?= esc($pemakaman['kode_blok']) ?>)</td></tr>
                            <tr><th>Baris/Nomor</th><td>: <?= esc($pemakaman['baris'] ?: '-') ?> / <?= esc($pemakaman['nomor'] ?: '-') ?></td></tr>
                            <tr><th>Tgl Pemakaman</th><td>: <?= date('d M Y H:i', strtotime($pemakaman['tanggal_pemakaman'])) ?></td></tr>
                            <tr><th>Masa Berlaku</th><td>: <?= $pemakaman['masa_berlaku'] ? date('d M Y', strtotime($pemakaman['masa_berlaku'])) : '-' ?></td></tr>
                            <tr><th>Status</th><td>: <span class="badge bg-<?= $pemakaman['status'] == 'aktif' ? 'success' : 'warning' ?>"><?= ucfirst($pemakaman['status']) ?></span></td></tr>
                        </table>
                    </div>
                </div>
                
                <hr>
                <h6>Biaya</h6>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1">Biaya Pemakaman: <strong><?= format_rupiah($pemakaman['biaya_pemakaman']) ?></strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1">Biaya Perawatan/Tahun: <strong><?= format_rupiah($pemakaman['biaya_perawatan_tahunan']) ?></strong></p>
                    </div>
                </div>
                <?php if ($pemakaman['catatan']): ?>
                    <hr>
                    <p class="mb-0"><strong>Catatan:</strong> <?= esc($pemakaman['catatan']) ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Tagihan -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-receipt me-2"></i>Riwayat Tagihan
            </div>
            <div class="card-body p-0">
                <?php if (empty($pemakaman['tagihan'])): ?>
                    <div class="text-center text-muted py-4">Belum ada tagihan</div>
                <?php else: ?>
                    <table class="table table-sm mb-0">
                        <thead><tr><th>No. Tagihan</th><th>Jenis</th><th>Total</th><th>Sisa</th><th>Status</th><th></th></tr></thead>
                        <tbody>
                            <?php foreach ($pemakaman['tagihan'] as $t): ?>
                                <tr>
                                    <td><?= esc($t['no_tagihan']) ?></td>
                                    <td><?= ucfirst($t['jenis_tagihan']) ?></td>
                                    <td><?= format_rupiah($t['total']) ?></td>
                                    <td class="<?= $t['sisa'] > 0 ? 'text-danger' : 'text-success' ?>"><?= format_rupiah($t['sisa']) ?></td>
                                    <td><span class="badge bg-<?= $t['status'] == 'lunas' ? 'success' : 'warning' ?>"><?= ucfirst($t['status']) ?></span></td>
                                    <td><a href="<?= base_url('tagihan/view/' . $t['id']) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>

        <!-- Perawatan -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-wrench me-2"></i>Riwayat Perawatan
            </div>
            <div class="card-body p-0">
                <?php if (empty($pemakaman['perawatan'])): ?>
                    <div class="text-center text-muted py-4">Belum ada perawatan</div>
                <?php else: ?>
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Tanggal</th><th>Jenis</th><th>Deskripsi</th><th>Biaya</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php foreach ($pemakaman['perawatan'] as $p): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($p['tanggal_perawatan'])) ?></td>
                                    <td><span class="badge bg-info"><?= ucfirst($p['jenis_perawatan']) ?></span></td>
                                    <td><?= esc($p['deskripsi']) ?></td>
                                    <td><?= format_rupiah($p['biaya']) ?></td>
                                    <td><span class="badge bg-<?= $p['status'] == 'selesai' ? 'success' : 'warning' ?>"><?= ucfirst($p['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Keluarga -->
        <div class="card">
            <div class="card-header"><i class="bi bi-people me-2"></i>Penanggung Jawab</div>
            <div class="card-body p-0">
                <?php if (empty($pemakaman['keluarga'])): ?>
                    <div class="text-center text-muted py-4">Tidak ada data keluarga</div>
                <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($pemakaman['keluarga'] as $k): ?>
                            <li class="list-group-item">
                                <h6 class="mb-1">
                                    <?= esc($k['nama_lengkap']) ?>
                                    <?php if ($k['is_penanggung_jawab']): ?>
                                        <span class="badge bg-primary">PJ</span>
                                    <?php endif; ?>
                                </h6>
                                <small class="text-muted">
                                    <?= esc($k['hubungan']) ?><br>
                                    <i class="bi bi-telephone"></i> <?= esc($k['no_telepon']) ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
