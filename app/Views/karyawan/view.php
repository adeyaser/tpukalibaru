<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-person me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <a href="<?= base_url('karyawan/edit/' . $karyawan['id']) ?>" class="btn btn-warning"><i class="bi bi-pencil me-1"></i>Edit</a>
        <a href="<?= base_url('gaji/create?karyawan_id=' . $karyawan['id']) ?>" class="btn btn-success"><i class="bi bi-cash me-1"></i>Buat Slip Gaji</a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <?php if ($karyawan['foto']): ?>
                    <img src="<?= base_url('uploads/karyawan/' . $karyawan['foto']) ?>" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <?php else: ?>
                    <div class="bg-secondary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px; font-size: 48px;">
                        <i class="bi bi-person"></i>
                    </div>
                <?php endif; ?>
                <h4><?= esc($karyawan['nama_lengkap']) ?></h4>
                <p class="text-muted"><?= esc($karyawan['jabatan']) ?></p>
                <span class="badge bg-<?= $karyawan['status'] == 'aktif' ? 'success' : 'secondary' ?> fs-6">
                    <?= ucfirst($karyawan['status']) ?>
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informasi Karyawan</div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr><th width="200">NIP</th><td>: <span class="badge bg-primary"><?= esc($karyawan['nip']) ?></span></td></tr>
                    <tr><th>Nama Lengkap</th><td>: <?= esc($karyawan['nama_lengkap']) ?></td></tr>
                    <tr><th>Jabatan</th><td>: <?= esc($karyawan['jabatan']) ?></td></tr>
                    <tr><th>No. Telepon</th><td>: <?= esc($karyawan['no_telepon'] ?: '-') ?></td></tr>
                    <tr><th>Email</th><td>: <?= esc($karyawan['email'] ?: '-') ?></td></tr>
                    <tr><th>Alamat</th><td>: <?= esc($karyawan['alamat'] ?: '-') ?></td></tr>
                    <tr><th>Tanggal Masuk</th><td>: <?= date('d M Y', strtotime($karyawan['tanggal_masuk'])) ?></td></tr>
                    <tr><th>Gaji Pokok</th><td>: <strong class="text-success"><?= format_rupiah($karyawan['gaji_pokok']) ?></strong></td></tr>
                </table>
            </div>
        </div>
        
        <!-- Riwayat Gaji -->
        <div class="card">
            <div class="card-header"><i class="bi bi-clock-history me-2"></i>Riwayat Gaji (12 Bulan Terakhir)</div>
            <div class="card-body p-0">
                <?php 
                $bulanNama = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                if (empty($karyawan['gaji'])): ?>
                    <div class="text-center text-muted py-4">Belum ada riwayat gaji</div>
                <?php else: ?>
                    <table class="table table-sm mb-0">
                        <thead><tr><th>Periode</th><th>Gaji Pokok</th><th>Tunjangan</th><th>Potongan</th><th>Gaji Bersih</th><th>Status</th></tr></thead>
                        <tbody>
                            <?php foreach ($karyawan['gaji'] as $g): ?>
                                <tr>
                                    <td><?= $bulanNama[$g['bulan']] ?> <?= $g['tahun'] ?></td>
                                    <td><?= format_rupiah($g['gaji_pokok']) ?></td>
                                    <td class="text-success">+<?= format_rupiah($g['total_tunjangan']) ?></td>
                                    <td class="text-danger">-<?= format_rupiah($g['total_potongan']) ?></td>
                                    <td class="fw-bold"><?= format_rupiah($g['gaji_bersih']) ?></td>
                                    <td><span class="badge bg-<?= $g['status'] == 'dibayar' ? 'success' : 'warning' ?>"><?= ucfirst($g['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
