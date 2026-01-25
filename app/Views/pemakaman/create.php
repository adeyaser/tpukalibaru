<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('pemakaman/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jenazah <span class="text-danger">*</span></label>
                        <select name="jenazah_id" class="form-select" required id="jenazah_id">
                            <option value="">Pilih Jenazah</option>
                            <?php foreach ($jenazah as $j): ?>
                                <option value="<?= $j['id'] ?>" <?= old('jenazah_id') == $j['id'] || service('request')->getGet('jenazah_id') == $j['id'] ? 'selected' : '' ?>>
                                    <?= esc($j['nama_lengkap']) ?> (<?= date('d M Y', strtotime($j['tanggal_wafat'])) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (empty($jenazah)): ?>
                            <div class="alert alert-warning mt-2 mb-0">
                                <i class="bi bi-exclamation-triangle"></i> Tidak ada jenazah yang belum dimakamkan. 
                                <a href="<?= base_url('jenazah/create') ?>">Tambah jenazah baru</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Lokasi Makam <span class="text-danger">*</span></label>
                        <select name="lokasi_makam_id" class="form-select" required id="lokasi_id">
                            <option value="">Pilih Lokasi</option>
                            <?php foreach ($lokasi as $l): ?>
                                <option value="<?= $l['id'] ?>" data-harga="<?= $l['harga_sewa'] ?>" <?= old('lokasi_makam_id') == $l['id'] ? 'selected' : '' ?>>
                                    <?= esc($l['nama_blok']) ?> (<?= esc($l['kode_blok']) ?>) - Tersedia: <?= $l['tersedia'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pemakaman <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="tanggal_pemakaman" class="form-control" value="<?= old('tanggal_pemakaman', date('Y-m-d\TH:i')) ?>" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Baris</label>
                        <input type="text" name="baris" class="form-control" value="<?= old('baris') ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Nomor</label>
                        <input type="text" name="nomor" class="form-control" value="<?= old('nomor') ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Biaya Pemakaman (Rp)</label>
                        <input type="number" name="biaya_pemakaman" class="form-control" value="<?= old('biaya_pemakaman') ?>" id="biaya">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Biaya Perawatan Tahunan (Rp)</label>
                        <input type="number" name="biaya_perawatan_tahunan" class="form-control" value="<?= old('biaya_perawatan_tahunan', 500000) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Masa Berlaku</label>
                        <input type="date" name="masa_berlaku" class="form-control" value="<?= old('masa_berlaku', date('Y-m-d', strtotime('+3 years'))) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"><?= old('catatan') ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Proses Pemakaman</button>
                <a href="<?= base_url('pemakaman') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('lokasi_id').addEventListener('change', function() {
    const option = this.options[this.selectedIndex];
    const harga = option.dataset.harga || 0;
    document.getElementById('biaya').value = harga;
});
</script>
<?= $this->endSection() ?>
