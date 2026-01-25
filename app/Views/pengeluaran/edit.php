<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('pengeluaran/update/' . $pengeluaran['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <strong>No. Pengeluaran:</strong> <?= esc($pengeluaran['no_pengeluaran']) ?>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <?php 
                            $categories = ['operasional', 'perawatan', 'listrik', 'air', 'kebersihan', 'keamanan', 'lainnya'];
                            foreach ($categories as $cat): 
                            ?>
                                <option value="<?= $cat ?>" <?= old('kategori', $pengeluaran['kategori']) == $cat ? 'selected' : '' ?>>
                                    <?= ucfirst($cat) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', $pengeluaran['tanggal']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                <textarea name="deskripsi" class="form-control" rows="2" required><?= old('deskripsi', $pengeluaran['deskripsi']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                        <input type="number" name="nominal" class="form-control" value="<?= old('nominal', $pengeluaran['nominal']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status Pembayaran <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="dibayar" <?= old('status', $pengeluaran['status']) == 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                            <option value="pending" <?= old('status', $pengeluaran['status']) == 'pending' ? 'selected' : '' ?>>Pending</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Bukti Pengeluaran (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="bukti" class="form-control" accept="image/*">
                <?php if ($pengeluaran['bukti']): ?>
                    <small class="text-muted d-block mt-1">
                        <a href="<?= base_url('uploads/pengeluaran/' . $pengeluaran['bukti']) ?>" target="_blank">Lihat bukti saat ini</a>
                    </small>
                <?php endif; ?>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('pengeluaran') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
