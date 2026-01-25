<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-receipt me-2"></i><?= esc($title) ?></h4>
    <div class="d-flex gap-2">
        <a href="<?= base_url('pembayaran') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
        <a href="<?= base_url('tagihan/view/' . $pembayaran['tagihan_id']) ?>" class="btn btn-info text-white">
            <i class="bi bi-eye me-1"></i>Lihat Tagihan
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Pembayaran</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 200px;">No. Pembayaran</th>
                        <td><span class="badge bg-primary"><?= esc($pembayaran['no_pembayaran']) ?></span></td>
                    </tr>
                    <tr>
                        <th>No. Tagihan</th>
                        <td>#<?= esc($pembayaran['no_tagihan']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Bayar</th>
                        <td><?= date('d M Y H:i', strtotime($pembayaran['tanggal_bayar'])) ?></td>
                    </tr>
                    <tr>
                        <th>Nominal</th>
                        <td class="fw-bold text-success fs-5">Rp <?= number_format($pembayaran['nominal'], 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <th>Metode Pembayaran</th>
                        <td><?= esc(ucfirst($pembayaran['metode_bayar'])) ?></td>
                    </tr>
                    <tr>
                        <th>Catatan</th>
                        <td><?= nl2br(esc($pembayaran['catatan'] ?: '-')) ?></td>
                    </tr>
                    <tr>
                        <th>Diterima Oleh (Kasir)</th>
                        <td><?= esc($pembayaran['kasir'] ?: 'System') ?></td>
                    </tr>
                    <tr>
                        <th>Waktu Input</th>
                        <td><?= date('d M Y H:i', strtotime($pembayaran['created_at'])) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 font-weight-bold text-primary">Bukti Pembayaran</h6>
            </div>
            <div class="card-body text-center">
                <?php if ($pembayaran['bukti_bayar']): ?>
                    <img src="<?= base_url('uploads/pembayaran/' . $pembayaran['bukti_bayar']) ?>" 
                         class="img-fluid rounded border shadow-sm mb-3" 
                         alt="Bukti Pembayaran">
                    <a href="<?= base_url('uploads/pembayaran/' . $pembayaran['bukti_bayar']) ?>" 
                       target="_blank" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-zoom-in me-1"></i>Perbesar
                    </a>
                <?php else: ?>
                    <div class="text-muted py-5">
                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                        Tidak ada bukti pembayaran
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
