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
                        <a href="<?= base_url('reports/perawatan') ?>" class="btn btn-secondary"><i class="bi bi-arrow-clockwise me-1"></i>Reset</a>
                        <a href="<?= base_url('reports/export/perawatan?start_date='.$startDate.'&end_date='.$endDate) ?>" target="_blank" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>PDF</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Laporan Perawatan Makam</h5>
                <div>
                    <span class="badge bg-secondary me-2">Total: <?= $total ?> Data</span>
                    <span class="badge bg-success">Total Biaya: <?= format_rupiah($totalBiaya) ?></span>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Tanggal Perawatan</th>
                                <th>Jenazah / Makam</th>
                                <th>Lokasi</th>
                                <th>Jenis Perawatan</th>
                                <th>Biaya</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($perawatan as $p): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($p['tanggal_perawatan'])) ?></td>
                                    <td>
                                        <strong><?= esc($p['nama_lengkap']) ?></strong><br>
                                        <small class="text-muted"><?= esc($p['no_makam']) ?></small>
                                    </td>
                                    <td><?= esc($p['nama_blok']) ?></td>
                                    <td><?= ucfirst($p['jenis_perawatan']) ?></td>
                                    <td><?= format_rupiah($p['biaya']) ?></td>
                                    <td>
                                        <span class="badge bg-<?= $p['status'] == 'selesai' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($p['status']) ?>
                                        </span>
                                    </td>
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
