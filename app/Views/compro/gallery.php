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
        <div class="row g-4">
            <?php if (!empty($gallery)): ?>
                <?php foreach ($gallery as $g): ?>
                <div class="col-md-4 col-sm-6" data-aos="zoom-in">
                    <div class="gallery-item position-relative overflow-hidden rounded-4 shadow-sm group">
                        <img src="<?= base_url('uploads/compro/' . $g['gambar']) ?>" alt="<?= esc($g['judul']) ?>" class="img-fluid w-100 object-fit-cover" style="height: 300px;">
                        <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-75 d-flex flex-column justify-content-end p-4 opacity-0 transition-all">
                            <h5 class="text-white mb-1"><?= esc($g['judul']) ?></h5>
                            <p class="text-white-50 small mb-0"><?= esc($g['deskripsi']) ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted">Belum ada foto galeri.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<style>
    .gallery-item:hover .gallery-overlay {
        opacity: 1 !important;
    }
    .gallery-item img {
        transition: transform 0.5s ease;
    }
    .gallery-item:hover img {
        transform: scale(1.1);
    }
</style>

<?= $this->endSection() ?>
