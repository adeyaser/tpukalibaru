<?= $this->extend('layouts/frontend') ?>

<?= $this->section('content') ?>

<!-- Page Header -->
<div class="page-header py-5 bg-light mb-5">
    <div class="container py-5">
        <h1 class="display-4 fw-bold text-center mb-3"><?= esc($title) ?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= esc($title) ?></li>
            </ol>
        </nav>
    </div>
</div>

<section class="section-padding mb-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $s): ?>
                <div class="col-md-4 col-lg-3" data-aos="fade-up">
                    <div class="service-card h-100 p-4 border rounded-4 text-center hover-shadow transition-all bg-white shadow-sm">
                        <div class="service-icon-box mb-4 d-inline-flex align-items-center justify-content-center rounded-circle bg-primary bg-opacity-10 text-primary" style="width: 80px; height: 80px;">
                            <i class="<?= esc($s['icon'] ?? 'bi-tree') ?> fs-1"></i>
                        </div>
                        <h4 class="h5 fw-bold mb-3"><?= esc($s['nama_layanan']) ?></h4>
                        <p class="text-muted small mb-0"><?= esc($s['deskripsi']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">Belum ada data layanan tersedia.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
