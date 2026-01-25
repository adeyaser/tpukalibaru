<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<?php helper('acl'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h4>
    <span class="text-muted"><?= date('l, d F Y') ?></span>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #1a365d 0%, #3182ce 100%);">
            <h3><?= number_format($totalPemakaman) ?></h3>
            <p class="mb-0 opacity-75">Makam Aktif</p>
            <i class="bi bi-tree stat-icon"></i>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);">
            <h3><?= number_format($totalJenazah) ?></h3>
            <p class="mb-0 opacity-75">Total Jenazah</p>
            <i class="bi bi-person-badge stat-icon"></i>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #276749 0%, #38a169 100%);">
            <h3><?= format_rupiah($pendapatanBulanIni, false) ?></h3>
            <p class="mb-0 opacity-75">Pendapatan Bulan Ini</p>
            <i class="bi bi-cash-stack stat-icon"></i>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg, #9c4221 0%, #dd6b20 100%);">
            <h3><?= format_rupiah($tagihanBelumLunas, false) ?></h3>
            <p class="mb-0 opacity-75">Tagihan Belum Lunas</p>
            <i class="bi bi-receipt stat-icon"></i>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-geo-alt fs-1 text-primary mb-2"></i>
                <h3 class="mb-1"><?= number_format($totalLokasi) ?></h3>
                <p class="text-muted mb-2">Blok Makam</p>
                <div class="progress" style="height: 8px;">
                    <?php $percentage = $kapasitasTotal > 0 ? ($terisiTotal / $kapasitasTotal * 100) : 0; ?>
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $percentage ?>%"></div>
                </div>
                <small class="text-muted"><?= number_format($terisiTotal) ?> / <?= number_format($kapasitasTotal) ?> terisi (<?= number_format($percentage, 1) ?>%)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="bi bi-people fs-1 text-success mb-2"></i>
                <h3 class="mb-1"><?= number_format($totalKaryawan) ?></h3>
                <p class="text-muted mb-0">Karyawan Aktif</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100 border-start border-4 border-info">
            <div class="card-body text-center">
                <i class="bi bi-chat-left-text fs-1 text-info mb-2"></i>
                <h3 class="mb-1"><?= number_format($unreadMessages) ?></h3>
                <p class="text-muted mb-0">Pesan Masuk Baru</p>
                <a href="<?= base_url('compro-settings/messages') ?>" class="btn btn-sm btn-info text-white mt-2 rounded-pill px-3">Lihat Pesan</a>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-bar-chart me-2"></i>Pemakaman 6 Bulan Terakhir
            </div>
            <div class="card-body">
                <canvas id="chartPemakaman" height="200"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header">
                <i class="bi bi-graph-up me-2"></i>Pendapatan vs Pengeluaran
            </div>
            <div class="card-body">
                <canvas id="chartKeuangan" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tables -->
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-clock-history me-2"></i>Pemakaman Terbaru</span>
                <a href="<?= base_url('pemakaman') ?>" class="btn btn-sm btn-light">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Jenazah</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentPemakaman)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">Belum ada data</td></tr>
                            <?php else: ?>
                                <?php foreach ($recentPemakaman as $p): ?>
                                    <tr>
                                        <td><?= esc($p['nama_lengkap']) ?></td>
                                        <td><span class="badge bg-secondary"><?= esc($p['nama_blok']) ?></span></td>
                                        <td><?= date('d M Y', strtotime($p['tanggal_pemakaman'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-exclamation-triangle me-2"></i>Tagihan Jatuh Tempo</span>
                <a href="<?= base_url('tagihan') ?>" class="btn btn-sm btn-light">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Jenazah</th>
                                <th>Sisa Tagihan</th>
                                <th>Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($tagihanJatuhTempo)): ?>
                                <tr><td colspan="3" class="text-center text-muted py-3">Tidak ada tagihan jatuh tempo</td></tr>
                            <?php else: ?>
                                <?php foreach ($tagihanJatuhTempo as $t): ?>
                                    <tr>
                                        <td><?= esc($t['nama_lengkap']) ?></td>
                                        <td class="text-danger fw-bold"><?= format_rupiah($t['sisa']) ?></td>
                                        <td>
                                            <?php 
                                            $jatuhTempo = strtotime($t['jatuh_tempo']);
                                            $today = strtotime(date('Y-m-d'));
                                            $class = $jatuhTempo < $today ? 'bg-danger' : 'bg-warning text-dark';
                                            ?>
                                            <span class="badge <?= $class ?>"><?= date('d M Y', $jatuhTempo) ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Chart Pemakaman
const ctxPemakaman = document.getElementById('chartPemakaman').getContext('2d');
new Chart(ctxPemakaman, {
    type: 'bar',
    data: {
        labels: <?= $chartLabels ?>,
        datasets: [{
            label: 'Jumlah Pemakaman',
            data: <?= $chartPemakaman ?>,
            backgroundColor: 'rgba(26, 54, 93, 0.8)',
            borderColor: 'rgba(26, 54, 93, 1)',
            borderWidth: 1,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
    }
});

// Chart Keuangan
const ctxKeuangan = document.getElementById('chartKeuangan').getContext('2d');
new Chart(ctxKeuangan, {
    type: 'line',
    data: {
        labels: <?= $chartLabels ?>,
        datasets: [{
            label: 'Pendapatan',
            data: <?= $chartPendapatan ?>,
            borderColor: 'rgba(39, 103, 73, 1)',
            backgroundColor: 'rgba(39, 103, 73, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Pengeluaran',
            data: <?= $chartPengeluaran ?>,
            borderColor: 'rgba(220, 53, 69, 1)',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        },
        scales: {
            y: { 
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
<?= $this->endSection() ?>
