<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-wrench me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('perawatan/store') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Makam/Jenazah <span class="text-danger">*</span></label>
                        <?php if (isset($selected_pemakaman)): ?>
                             <select name="pemakaman_id" class="form-select" readonly>
                                <option value="<?= $selected_pemakaman['id'] ?>" selected>
                                    <?= esc($selected_pemakaman['no_makam']) ?> - <?= esc($selected_pemakaman['nama_jenazah']) ?>
                                </option>
                            </select>
                        <?php else: ?>
                            <select name="pemakaman_id" class="form-select" required>
                                <option value="">Pilih Makam</option>
                                <?php foreach ($pemakaman as $p): ?>
                                    <option value="<?= $p['id'] ?>">
                                        <?= esc($p['no_makam']) ?> - <?= esc($p['nama_jenazah']) ?> (Blok <?= esc($p['kode_blok']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Perawatan <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_perawatan" class="form-control" value="<?= old('tanggal_perawatan', date('Y-m-d')) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-select">
                            <option value="rumput">Pemotongan Rumput</option>
                            <option value="bersih">Pembersihan Makam</option>
                            <option value="cat">Pengecatan/Perbaikan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Biaya (Rp)</label>
                        <input type="number" name="biaya" class="form-control" value="<?= old('biaya', 0) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" class="form-control" rows="3" required><?= old('deskripsi') ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Foto Sebelum (Opsional)</label>
                        <input type="file" name="foto_sebelum" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Foto Sesudah (Opsional)</label>
                        <input type="file" name="foto_sesudah" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="<?= base_url('perawatan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
