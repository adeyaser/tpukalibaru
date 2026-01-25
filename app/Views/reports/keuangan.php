<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="" method="get" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $startDate ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $endDate ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-filter me-1"></i>Filter</button>
                        <a href="<?= base_url('reports/keuangan') ?>" class="btn btn-secondary"><i class="bi bi-arrow-clockwise me-1"></i>Reset</a>
                        <a href="<?= base_url('reports/export/keuangan?start_date='.$startDate.'&end_date='.$endDate) ?>" target="_blank" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>PDF</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Total Pendapatan</h6>
                <h3 class="mb-0"><?= format_rupiah($pendapatan) ?></h3>
                <small>Pembayaran Tagihan</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Total Pengeluaran</h6>
                <h3 class="mb-0"><?= format_rupiah($totalPengeluaran) ?></h3>
                <small>Operasional, Aset, & Gaji</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card <?= $saldo >= 0 ? 'bg-primary' : 'bg-warning' ?> text-white h-100">
            <div class="card-body">
                <h6 class="card-title">Saldo Akhir</h6>
                <h3 class="mb-0"><?= format_rupiah($saldo) ?></h3>
                <small>Periode Ini</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Rincian Pengeluaran</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <tr>
                        <td>Biaya Operasional</td>
                        <td class="text-end number"><?= format_rupiah($pengeluaran) ?></td>
                    </tr>
                    <tr>
                        <td>Pembelian Alat/Aset</td>
                        <td class="text-end number"><?= format_rupiah($pembelian) ?></td>
                    </tr>
                    <tr>
                        <td>Gaji Karyawan</td>
                        <td class="text-end number"><?= format_rupiah($gaji) ?></td>
                    </tr>
                    <tr class="fw-bold">
                        <td>Total</td>
                        <td class="text-end number"><?= format_rupiah($totalPengeluaran) ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Riwayat Pembayaran Masuk Terbaru</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Tagihan</th>
                                <th class="text-end">Nominal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($pembayaranList, 0, 5) as $p): ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($p['tanggal_bayar'])) ?></td>
                                    <td><?= esc($p['no_tagihan']) ?></td>
                                    <td class="text-end text-success">+ <?= format_rupiah($p['nominal'], false) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
