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
                        <a href="<?= base_url('reports/pemakaman') ?>" class="btn btn-secondary"><i class="bi bi-arrow-clockwise me-1"></i>Reset</a>
                        <a href="<?= base_url('reports/export/pemakaman?start_date='.$startDate.'&end_date='.$endDate) ?>" target="_blank" class="btn btn-danger"><i class="bi bi-file-pdf me-1"></i>PDF</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Ringkasan per Blok</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($summaryByLokasi as $sum): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= esc($sum['nama_blok']) ?>
                            <span class="badge bg-primary rounded-pill"><?= $sum['total'] ?></span>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($summaryByLokasi)): ?>
                        <li class="list-group-item text-muted text-center">Tidak ada data</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-8 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Pemakaman</h5>
                <span class="badge bg-info text-dark">Total: <?= $total ?> Data</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jenazah</th>
                                <th>Blok Makam</th>
                                <th>Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pemakaman as $p): ?>
                                <tr>
                                    <td><?= date('d M Y', strtotime($p['tanggal_pemakaman'])) ?></td>
                                    <td>
                                        <strong><?= esc($p['nama_jenazah']) ?></strong><br>
                                        <small class="text-muted">Wafat: <?= date('d M Y', strtotime($p['tanggal_wafat'])) ?></small>
                                    </td>
                                    <td><?= esc($p['nama_blok']) ?> (<?= esc($p['kode_blok']) ?>)</td>
                                    <td><?= date('H:i', strtotime($p['tanggal_pemakaman'])) ?></td>
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
