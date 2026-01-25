<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-plus-circle me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= base_url('tagihan/store') ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Pemakaman <span class="text-danger">*</span></label>
                        <select name="pemakaman_id" class="form-select" required id="pemakaman_select">
                            <option value="">Pilih Pemakaman</option>
                            <?php foreach ($pemakaman as $p): ?>
                                <option value="<?= $p['id'] ?>" data-keluarga="<?= htmlspecialchars(json_encode($p)) ?>">
                                    <?= esc($p['no_makam']) ?> - <?= esc($p['nama_jenazah']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jenis Tagihan <span class="text-danger">*</span></label>
                        <select name="jenis_tagihan" class="form-select" required id="jenis_tagihan_select">
                            <option value="pemakaman">Biaya Pemakaman</option>
                            <option value="perawatan_tahunan">Perawatan Tahunan</option>
                            <option value="perpanjangan">Perpanjangan</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label d-flex justify-content-between align-items-center">
                    Rincian Tagihan <span class="text-danger">*</span>
                    <button type="button" class="btn btn-sm btn-success" id="add_item">
                        <i class="bi bi-plus-lg me-1"></i>Tambah Baris
                    </button>
                </label>
                <div class="table-responsive">
                    <table class="table table-bordered" id="items_table">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Item / Deskripsi</th>
                                <th width="30%">Nominal (Rp)</th>
                                <th width="50px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="item_name[]" class="form-control" required placeholder="Contoh: Biaya Gali Lubang" id="first_item_name" value="Biaya Pemakaman"></td>
                                <td><input type="number" name="item_nominal[]" class="form-control item-nominal" required min="0" value="0"></td>
                                <td></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr class="table-light fw-bold">
                                <td class="text-end">Total Nominal</td>
                                <td><input type="text" id="total_nominal_display" class="form-control" readonly value="0"></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Denda (Rp)</label>
                        <input type="number" name="denda" id="denda" class="form-control" value="<?= old('denda', 0) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                        <input type="date" name="jatuh_tempo" class="form-control" value="<?= old('jatuh_tempo', date('Y-m-d', strtotime('+30 days'))) ?>" required>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode Mulai</label>
                        <input type="date" name="periode_mulai" class="form-control" value="<?= old('periode_mulai') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode Akhir</label>
                        <input type="date" name="periode_akhir" class="form-control" value="<?= old('periode_akhir') ?>">
                    </div>
                </div>
            </div>
            
            <input type="hidden" name="keluarga_id" id="keluarga_id" value="">
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Buat Tagihan</button>
                <a href="<?= base_url('tagihan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pemakamanSelect = document.getElementById('pemakaman_select');
        const keluargaIdInput = document.getElementById('keluarga_id');
        const itemsTable = document.getElementById('items_table').getElementsByTagName('tbody')[0];
        const addItemBtn = document.getElementById('add_item');
        const totalDisplay = document.getElementById('total_nominal_display');
        const jenisTagihanSelect = document.getElementById('jenis_tagihan_select');
        const firstItemName = document.getElementById('first_item_name');

        jenisTagihanSelect.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            // Only update if it matches previous automatic value or is empty
            if (firstItemName.value === '' || firstItemName.dataset.isAuto === 'true' || firstItemName.dataset.isAuto === undefined) {
                firstItemName.value = selectedText;
                firstItemName.dataset.isAuto = 'true';
            }
        });

        firstItemName.addEventListener('input', function() {
            this.dataset.isAuto = 'false';
        });

        pemakamanSelect.addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            if (selected.value) {
                const data = JSON.parse(selected.getAttribute('data-keluarga'));
                keluargaIdInput.value = data.keluarga_id;
            } else {
                keluargaIdInput.value = '';
            }
        });

        addItemBtn.addEventListener('click', function() {
            const row = itemsTable.insertRow();
            row.innerHTML = `
                <td><input type="text" name="item_name[]" class="form-control" required></td>
                <td><input type="number" name="item_nominal[]" class="form-control item-nominal" required min="0" value="0"></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            initRemoveButtons();
            initCalculation();
        });

        function initRemoveButtons() {
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.onclick = function() {
                    this.closest('tr').remove();
                    calculateTotal();
                };
            });
        }

        function initCalculation() {
            document.querySelectorAll('.item-nominal').forEach(input => {
                input.oninput = calculateTotal;
            });
        }

        function calculateTotal() {
            let total = 0;
            document.querySelectorAll('.item-nominal').forEach(input => {
                total += parseFloat(input.value || 0);
            });
            totalDisplay.value = new Intl.NumberFormat('id-ID').format(total);
        }

        initCalculation();
    });
</script>
<?= $this->endSection() ?>
