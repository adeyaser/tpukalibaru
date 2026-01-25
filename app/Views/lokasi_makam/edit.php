<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('lokasi-makam/update/' . $lokasi['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Kode Blok <span class="text-danger">*</span></label>
                        <input type="text" name="kode_blok" class="form-control" value="<?= old('kode_blok', $lokasi['kode_blok']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Blok <span class="text-danger">*</span></label>
                        <input type="text" name="nama_blok" class="form-control" value="<?= old('nama_blok', $lokasi['nama_blok']) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Kapasitas <span class="text-danger">*</span></label>
                        <input type="number" name="kapasitas" class="form-control" value="<?= old('kapasitas', $lokasi['kapasitas']) ?>" min="1" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Terisi</label>
                        <input type="number" name="terisi" class="form-control" value="<?= old('terisi', $lokasi['terisi']) ?>" min="0" readonly>
                        <small class="text-muted">Diperbarui otomatis saat ada pemakaman</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Harga Sewa (Rp)</label>
                        <input type="number" name="harga_sewa" class="form-control" value="<?= old('harga_sewa', $lokasi['harga_sewa']) ?>" min="0">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3"><?= old('deskripsi', $lokasi['deskripsi']) ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('lokasi-makam') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
