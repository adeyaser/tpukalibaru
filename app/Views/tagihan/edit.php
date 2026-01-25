<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i><?= esc($title) ?></h4>
</div>

<div class="card">
    <div class="card-body">
        <div class="alert alert-info mb-4">
            <strong>No. Tagihan:</strong> <?= esc($tagihan['no_tagihan']) ?>
        </div>
        
        <form action="<?= base_url('tagihan/update/' . $tagihan['id']) ?>" method="POST">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jenis Tagihan</label>
                        <select name="jenis_tagihan" class="form-select" id="jenis_tagihan_select">
                            <option value="pemakaman" <?= old('jenis_tagihan', $tagihan['jenis_tagihan']) == 'pemakaman' ? 'selected' : '' ?>>Biaya Pemakaman</option>
                            <option value="perawatan_tahunan" <?= old('jenis_tagihan', $tagihan['jenis_tagihan']) == 'perawatan_tahunan' ? 'selected' : '' ?>>Perawatan Tahunan</option>
                            <option value="perpanjangan" <?= old('jenis_tagihan', $tagihan['jenis_tagihan']) == 'perpanjangan' ? 'selected' : '' ?>>Perpanjangan</option>
                            <option value="lainnya" <?= old('jenis_tagihan', $tagihan['jenis_tagihan']) == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Jatuh Tempo</label>
                        <input type="date" name="jatuh_tempo" class="form-control" value="<?= old('jatuh_tempo', $tagihan['jatuh_tempo']) ?>">
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
                            <?php if (empty($tagihan['items'])): ?>
                                <tr>
                                    <td><input type="text" name="item_name[]" class="form-control" required value="Biaya <?= ucfirst(str_replace('_', ' ', $tagihan['jenis_tagihan'])) ?>" id="first_item_name"></td>
                                    <td><input type="number" name="item_nominal[]" class="form-control item-nominal" required min="0" value="<?= $tagihan['nominal'] ?>"></td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <?php $isFirst = true; foreach ($tagihan['items'] as $item): ?>
                                    <tr>
                                        <td><input type="text" name="item_name[]" class="form-control" required value="<?= esc($item['nama_item']) ?>" <?= $isFirst ? 'id="first_item_name"' : '' ?>></td>
                                        <td><input type="number" name="item_nominal[]" class="form-control item-nominal" required min="0" value="<?= $item['nominal'] ?>"></td>
                                        <td class="text-center">
                                            <?php if (!$isFirst): ?>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php $isFirst = false; endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-light fw-bold">
                                <td class="text-end">Total Nominal</td>
                                <td><input type="text" id="total_nominal_display" class="form-control" readonly value="<?= number_format($tagihan['nominal'], 0, ',', '.') ?>"></td>
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
                        <input type="number" name="denda" id="denda" class="form-control" value="<?= old('denda', $tagihan['denda']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="belum_bayar" <?= old('status', $tagihan['status']) == 'belum_bayar' ? 'selected' : '' ?>>Belum Bayar</option>
                            <option value="cicilan" <?= old('status', $tagihan['status']) == 'cicilan' ? 'selected' : '' ?>>Cicilan</option>
                            <option value="lunas" <?= old('status', $tagihan['status']) == 'lunas' ? 'selected' : '' ?>>Lunas</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode Mulai</label>
                        <input type="date" name="periode_mulai" class="form-control" value="<?= old('periode_mulai', $tagihan['periode_mulai']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Periode Akhir</label>
                        <input type="date" name="periode_akhir" class="form-control" value="<?= old('periode_akhir', $tagihan['periode_akhir']) ?>">
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i>Update</button>
                <a href="<?= base_url('tagihan/view/' . $tagihan['id']) ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemsTable = document.getElementById('items_table').getElementsByTagName('tbody')[0];
        const addItemBtn = document.getElementById('add_item');
        const totalDisplay = document.getElementById('total_nominal_display');
        const jenisTagihanSelect = document.getElementById('jenis_tagihan_select');
        const firstItemName = document.getElementById('first_item_name');

        jenisTagihanSelect.addEventListener('change', function() {
            const selectedText = this.options[this.selectedIndex].text;
            if (firstItemName.value === '' || firstItemName.dataset.isAuto === 'true') {
                firstItemName.value = selectedText;
                firstItemName.dataset.isAuto = 'true';
            }
        });

        firstItemName.addEventListener('input', function() {
            this.dataset.isAuto = 'false';
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

        initRemoveButtons();
        initCalculation();
    });
</script>
<?= $this->endSection() ?>
