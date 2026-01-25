<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('gaji/update/' . $gaji['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="alert alert-info">
                <strong>Karyawan:</strong> <?= esc($gaji['nama_lengkap']) ?> (<?= esc($gaji['nip']) ?>)
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="month" name="periode" class="form-control" value="<?= old('periode', $gaji['periode']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= old('status', $gaji['status']) == 'pending' ? 'selected' : '' ?>>Draft/Pending</option>
                            <option value="dibayar" <?= old('status', $gaji['status']) == 'dibayar' ? 'selected' : '' ?>>Dibayar</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Gaji Pokok (Rp)</label>
                        <input type="number" name="gaji_pokok" class="form-control" value="<?= old('gaji_pokok', $gaji['gaji_pokok']) ?>" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Total Tunjangan (Rp)</label>
                        <input type="number" name="total_tunjangan" class="form-control" value="<?= old('total_tunjangan', $gaji['total_tunjangan']) ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Potongan (Rp)</label>
                        <input type="number" name="potongan" class="form-control" value="<?= old('potongan', $gaji['potongan']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"><?= old('catatan', $gaji['catatan']) ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('gaji') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
