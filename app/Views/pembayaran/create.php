<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cash me-2"></i><?= esc($title) ?></h4>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Info Tagihan -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="bi bi-receipt me-2"></i>Informasi Tagihan
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><th>No. Tagihan</th><td>: <?= esc($tagihan['no_tagihan']) ?></td></tr>
                    <tr><th>Nama Jenazah</th><td>: <?= esc($tagihan['nama_jenazah']) ?></td></tr>
                    <tr><th>Nama Keluarga</th><td>: <?= esc($tagihan['nama_keluarga']) ?></td></tr>
                    <tr><th>Total Tagihan</th><td>: <strong><?= format_rupiah($tagihan['total']) ?></strong></td></tr>
                    <tr><th>Terbayar</th><td>: <span class="text-success"><?= format_rupiah($tagihan['terbayar']) ?></span></td></tr>
                    <tr><th>Sisa</th><td>: <span class="text-danger fw-bold"><?= format_rupiah($tagihan['sisa']) ?></span></td></tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2"></i>Input Pembayaran
            </div>
            <div class="card-body">
                <form action="<?= base_url('pembayaran/store') ?>" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <input type="hidden" name="tagihan_id" value="<?= esc($tagihan['id']) ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nominal Bayar <span class="text-danger">*</span></label>
                                <input type="number" name="nominal" class="form-control" value="<?= old('nominal', $tagihan['sisa']) ?>" max="<?= $tagihan['sisa'] ?>" required>
                                <small class="text-muted">Maksimal: <?= format_rupiah($tagihan['sisa']) ?></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Bayar</label>
                                <input type="datetime-local" name="tanggal_bayar" class="form-control" value="<?= old('tanggal_bayar', date('Y-m-d\TH:i')) ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <select name="metode_bayar" class="form-select">
                                    <option value="tunai">Tunai</option>
                                    <option value="transfer">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Bukti Bayar</label>
                                <input type="file" name="bukti_bayar" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"><?= old('catatan') ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i>Proses Pembayaran</button>
                        <a href="<?= base_url('tagihan/view/' . $tagihan['id']) ?>" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
