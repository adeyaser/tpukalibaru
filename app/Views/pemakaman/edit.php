<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('pemakaman/update/' . $pemakaman['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <strong>No. Makam:</strong> <?= esc($pemakaman['no_makam']) ?>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Lokasi Makam</label>
                        <select name="lokasi_makam_id" class="form-select" required>
                            <?php foreach ($lokasi as $l): ?>
                                <option value="<?= $l['id'] ?>" <?= old('lokasi_makam_id', $pemakaman['lokasi_makam_id']) == $l['id'] ? 'selected' : '' ?>>
                                    <?= esc($l['nama_blok']) ?> (<?= esc($l['kode_blok']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="aktif" <?= old('status', $pemakaman['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                            <option value="kadaluarsa" <?= old('status', $pemakaman['status']) == 'kadaluarsa' ? 'selected' : '' ?>>Kadaluarsa</option>
                            <option value="dipindahkan" <?= old('status', $pemakaman['status']) == 'dipindahkan' ? 'selected' : '' ?>>Dipindahkan</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Baris</label>
                        <input type="text" name="baris" class="form-control" value="<?= old('baris', $pemakaman['baris']) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nomor</label>
                        <input type="text" name="nomor" class="form-control" value="<?= old('nomor', $pemakaman['nomor']) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Masa Berlaku</label>
                        <input type="date" name="masa_berlaku" class="form-control" value="<?= old('masa_berlaku', $pemakaman['masa_berlaku']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Biaya Pemakaman (Rp)</label>
                        <input type="number" name="biaya_pemakaman" class="form-control" value="<?= old('biaya_pemakaman', $pemakaman['biaya_pemakaman']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Biaya Perawatan Tahunan (Rp)</label>
                        <input type="number" name="biaya_perawatan_tahunan" class="form-control" value="<?= old('biaya_perawatan_tahunan', $pemakaman['biaya_perawatan_tahunan']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"><?= old('catatan', $pemakaman['catatan']) ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('pemakaman/view/' . $pemakaman['id']) ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
