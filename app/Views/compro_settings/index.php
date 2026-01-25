<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0"><i class="bi bi-window me-2"></i><?= esc($title) ?></h4>
</div>

<div class="row">
    <!-- Hero Section -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="display-4 mb-3 text-primary"><i class="bi bi-image"></i></div>
                <h5 class="card-title">Hero Section</h5>
                <p class="card-text text-muted">Atur gambar utama, judul, dan tombol CTA di halaman depan.</p>
                <a href="<?= base_url('compro-settings/hero') ?>" class="btn btn-outline-primary stretched-link">Kelola</a>
            </div>
        </div>
    </div>
    
    <!-- About Section -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="display-4 mb-3 text-success"><i class="bi bi-info-circle"></i></div>
                <h5 class="card-title">Tentang Kami</h5>
                <p class="card-text text-muted">Atur deskripsi profil, visi, dan misi layanan pemakaman.</p>
                <a href="<?= base_url('compro-settings/about') ?>" class="btn btn-outline-success stretched-link">Kelola</a>
            </div>
        </div>
    </div>
    
    <!-- Services -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="display-4 mb-3 text-info"><i class="bi bi-grid-3x3-gap"></i></div>
                <h5 class="card-title">Layanan</h5>
                <p class="card-text text-muted">Kelola daftar layanan yang ditampilkan di website.</p>
                <a href="<?= base_url('compro-settings/services') ?>" class="btn btn-outline-info stretched-link">Kelola</a>
            </div>
        </div>
    </div>
    
    <!-- Gallery -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="display-4 mb-3 text-warning"><i class="bi bi-images"></i></div>
                <h5 class="card-title">Galeri Foto</h5>
                <p class="card-text text-muted">Upload dan kelola foto-foto kegiatan atau fasilitas.</p>
                <a href="<?= base_url('compro-settings/gallery') ?>" class="btn btn-outline-warning stretched-link">Kelola</a>
            </div>
        </div>
    </div>
    
    <!-- Contact -->
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <div class="display-4 mb-3 text-danger"><i class="bi bi-telephone"></i></div>
                <h5 class="card-title">Kontak & Lokasi</h5>
                <p class="card-text text-muted">Atur informasi kontak, jam operasional, dan peta lokasi.</p>
                <a href="<?= base_url('compro-settings/contact') ?>" class="btn btn-outline-danger stretched-link">Kelola</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
