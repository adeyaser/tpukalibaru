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
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="<?= base_url('uploads/compro/' . ($about['gambar'] ?? 'about.jpg')) ?>" alt="About" class="img-fluid rounded-4 shadow-lg w-100">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <span class="section-subtitle text-primary fw-bold text-uppercase d-block mb-2">Tentang Kami</span>
                <h2 class="display-6 fw-bold mb-4"><?= esc($about['judul'] ?? 'SI-MAKAM') ?></h2>
                <div class="text-muted mb-4 lead">
                    <?= nl2br(esc($about['deskripsi'] ?? '')) ?>
                </div>
                
                <h5 class="fw-bold mb-3">Visi</h5>
                <p class="text-muted mb-4"><?= esc($about['visi'] ?? 'Menjadi penyedia layanan pemakaman yang terpercaya dan profesional.') ?></p>
                
                <h5 class="fw-bold mb-3">Misi</h5>
                <p class="text-muted mb-0"><?= nl2br(esc($about['misi'] ?? '- Memberikan pelayanan terbaik dengan empati')) ?></p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
