<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-cash-coin me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('gaji/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Karyawan <span class="text-danger">*</span></label>
                        <select name="karyawan_id" class="form-select" required id="karyawan_select">
                            <option value="">Pilih Karyawan</option>
                            <?php foreach ($karyawan as $k): ?>
                                <option value="<?= $k['id'] ?>" data-gaji="<?= $k['gaji_pokok'] ?>">
                                    <?= esc($k['nama_lengkap']) ?> - <?= esc($k['nip']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="<?= old('tanggal_bayar', date('Y-m-d')) ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Gaji Pokok (Rp)</label>
                        <input type="number" name="gaji_pokok" id="gaji_pokok" class="form-control" value="<?= old('gaji_pokok') ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tunjangan</label>
                    <div class="row g-2">
                        <div class="col-8">
                            <select name="tunjangan_ids[]" id="tunjangan_select" class="form-select" multiple>
                                <?php foreach ($tunjangan as $t): ?>
                                    <option value="<?= $t['id'] ?>" data-nominal="<?= $t['nominal'] ?>">
                                        <?= esc($t['nama_tunjangan']) ?> (<?= format_rupiah($t['nominal']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="total_tunjangan" id="total_tunjangan" class="form-control" value="<?= old('total_tunjangan', 0) ?>" readonly placeholder="Total">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Potongan (Rp)</label>
                        <input type="number" name="potongan" class="form-control" value="<?= old('potongan', 0) ?>">
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="month" name="periode" class="form-control" value="<?= old('periode', date('Y-m')) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending">Draft/Pending</option>
                            <option value="dibayar">Dibayar</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <textarea name="catatan" class="form-control" rows="2"><?= old('catatan') ?></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Simpan</button>
                <a href="<?= base_url('gaji') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select2 Initialization
    $('#tunjangan_select').select2({
        theme: 'bootstrap-5',
        placeholder: 'Pilih Tunjangan',
        allowClear: true
    });

    const karyawanSelect = document.getElementById('karyawan_select');
    const gajiPokokInput = document.getElementById('gaji_pokok');
    const totalTunjanganInput = document.getElementById('total_tunjangan');
    
    // Karyawan Change Listener
    karyawanSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const gaji = selectedOption.getAttribute('data-gaji');
        gajiPokokInput.value = gaji || 0;
    });

    // Tunjangan Change Listener (using jQuery for Select2)
    $('#tunjangan_select').on('change', function() {
        let total = 0;
        const selectedOptions = $(this).find('option:selected');
        
        selectedOptions.each(function() {
            total += parseFloat($(this).data('nominal')) || 0;
        });

        totalTunjanganInput.value = total;
    });
});
</script>
<?= $this->endSection() ?>
