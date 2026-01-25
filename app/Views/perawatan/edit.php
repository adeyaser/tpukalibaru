<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('perawatan/update/' . $perawatan['id']) ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <strong>Makam:</strong> <?= esc($perawatan['no_makam']) ?> - <?= esc($perawatan['nama_jenazah']) ?>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Perawatan</label>
                        <input type="date" name="tanggal_perawatan" class="form-control" value="<?= old('tanggal_perawatan', $perawatan['tanggal_perawatan']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="dijadwalkan" <?= old('status', $perawatan['status']) == 'dijadwalkan' ? 'selected' : '' ?>>Dijadwalkan</option>
                            <option value="dikerjakan" <?= old('status', $perawatan['status']) == 'dikerjakan' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                            <option value="selesai" <?= old('status', $perawatan['status']) == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jenis Perawatan</label>
                        <select name="jenis_perawatan" class="form-select">
                            <option value="rumput" <?= old('jenis_perawatan', $perawatan['jenis_perawatan']) == 'rumput' ? 'selected' : '' ?>>Pemotongan Rumput</option>
                            <option value="bersih" <?= old('jenis_perawatan', $perawatan['jenis_perawatan']) == 'bersih' ? 'selected' : '' ?>>Pembersihan Makam</option>
                            <option value="cat" <?= old('jenis_perawatan', $perawatan['jenis_perawatan']) == 'cat' ? 'selected' : '' ?>>Pengecatan/Perbaikan</option>
                            <option value="lainnya" <?= old('jenis_perawatan', $perawatan['jenis_perawatan']) == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Biaya (Rp)</label>
                        <input type="number" name="biaya" class="form-control" value="<?= old('biaya', $perawatan['biaya']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi Pekerjaan</label>
                <textarea name="deskripsi" class="form-control" rows="3" required><?= old('deskripsi', $perawatan['deskripsi']) ?></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Foto Sebelum (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="foto_sebelum" class="form-control" accept="image/*">
                        <?php if ($perawatan['foto_sebelum']): ?>
                            <div class="mt-2">
                                <img src="<?= base_url('uploads/perawatan/' . $perawatan['foto_sebelum']) ?>" alt="Foto Sebelum" class="img-thumbnail" style="height: 100px">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Foto Sesudah (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="foto_sesudah" class="form-control" accept="image/*">
                        <?php if ($perawatan['foto_sesudah']): ?>
                            <div class="mt-2">
                                <img src="<?= base_url('uploads/perawatan/' . $perawatan['foto_sesudah']) ?>" alt="Foto Sesudah" class="img-thumbnail" style="height: 100px">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('perawatan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
