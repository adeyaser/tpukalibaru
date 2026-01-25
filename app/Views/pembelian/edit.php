<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('pembelian/update/' . $pembelian['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <strong>No. Pembelian:</strong> <?= esc($pembelian['no_pembelian']) ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Alat / Barang <span class="text-danger">*</span></label>
                        <input type="text" name="nama_barang" class="form-control" value="<?= old('nama_barang', $pembelian['nama_barang']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Toko / Supplier <span class="text-danger">*</span></label>
                        <input type="text" name="supplier" class="form-control" value="<?= old('supplier', $pembelian['supplier']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pembelian <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_beli" class="form-control" value="<?= old('tanggal_beli', $pembelian['tanggal_beli']) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Jumlah <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" value="<?= old('jumlah', $pembelian['jumlah']) ?>" min="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Harga Satuan (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="harga_satuan" class="form-control" value="<?= old('harga_satuan', $pembelian['harga_satuan']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi / Keterangan</label>
                <textarea name="deskripsi" class="form-control" rows="2"><?= old('deskripsi', $pembelian['deskripsi']) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Pembelian (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="bukti" class="form-control" accept="image/*">
                <?php if ($pembelian['bukti']): ?>
                    <small class="text-muted d-block mt-1">
                        <a href="<?= base_url('uploads/pembelian/' . $pembelian['bukti']) ?>" target="_blank">Lihat bukti saat ini</a>
                    </small>
                <?php endif; ?>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('pembelian') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
