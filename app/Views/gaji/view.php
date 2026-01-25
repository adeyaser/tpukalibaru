<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-file-text me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <a href="<?= base_url('gaji') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <a href="<?= base_url('gaji/print/' . $gaji['id']) ?>" target="_blank" class="btn btn-primary">
            <i class="bi bi-file-pdf me-1"></i>Cetak PDF
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header text-center py-4">
                <h5 class="mb-1 fw-bold">SLIP GAJI KARYAWAN</h5>
                <p class="mb-0 text-white">Periode: <?= date('F Y', strtotime($gaji['periode'] . '-01')) ?></p>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-borderless table-sm">
                            <tr>
                                <td class="text-muted" width="100">Nama</td>
                                <td class="fw-bold">: <?= esc($gaji['nama_lengkap']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIP</td>
                                <td class="fw-bold">: <?= esc($gaji['nip']) ?></td>
                            </tr>
                            <tr>
                                <td class="text-muted">Jabatan</td>
                                <td class="fw-bold">: <?= esc($gaji['jabatan']) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <span class="badge bg-<?= $gaji['status'] == 'dibayar' ? 'success' : 'warning' ?> fs-6">
                            <?= ucfirst($gaji['status']) ?>
                        </span>
                        <?php if ($gaji['status'] == 'dibayar'): ?>
                            <div class="text-muted small mt-2">
                                Dibayar pada: <br>
                                <?= date('d M Y H:i', strtotime($gaji['tanggal_bayar'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-bold mb-3">Rincian Pendapatan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Gaji Pokok</td>
                                <td class="text-end"><?= format_rupiah($gaji['gaji_pokok']) ?></td>
                            </tr>
                            <tr>
                                <td>Tunjangan</td>
                                <td class="text-end text-success">+ <?= format_rupiah($gaji['total_tunjangan']) ?></td>
                            </tr>
                        </table>

                        <h6 class="fw-bold mb-3 mt-4">Potongan</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Potongan Lain-lain</td>
                                <td class="text-end text-danger">- <?= format_rupiah($gaji['potongan']) ?></td>
                            </tr>
                        </table>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">Total Gaji Bersih</h5>
                            <h4 class="fw-bold text-primary mb-0"><?= format_rupiah($gaji['total_gaji']) ?></h4>
                        </div>
                    </div>
                </div>
                
                <?php if ($gaji['catatan']): ?>
                    <div class="alert alert-light mt-4 mb-0 border">
                        <strong class="d-block mb-1">Catatan:</strong>
                        <?= nl2br(esc($gaji['catatan'])) ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($gaji['status'] !== 'dibayar' && can_update('gaji')): ?>
                <div class="card-footer bg-light p-3 text-end d-print-none">
                    <a href="<?= base_url('gaji/edit/' . $gaji['id']) ?>" class="btn btn-warning me-2">
                        <i class="bi bi-pencil me-1"></i>Edit
                    </a>
                    <a href="<?= base_url('gaji/bayar/' . $gaji['id']) ?>" class="btn btn-success" onclick="return confirm('Proses pembayaran gaji ini?')">
                        <i class="bi bi-cash-coin me-1"></i>Proses Pembayaran
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .ignore-print, .sidebar, .top-navbar, .d-print-none {
        display: none !important;
    }
    .main-content {
        margin: 0 !important;
        padding: 0 !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
<?= $this->endSection() ?>
