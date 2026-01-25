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
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <h3 class="fw-bold mb-4">Informasi Kontak</h3>
                <p class="text-muted mb-4">Silakan hubungi kami melalui kontak di bawah ini atau kunjungi kantor kami untuk informasi lebih lanjut.</p>
                
                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <img src="<?= base_url('assets/img/logo-bekasi.jpg') ?>" alt="Logo Bekasi" class="img-fluid" style="max-height: 50px;">
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Alamat</h6>
                        <p class="text-muted mb-0"><?= nl2br(esc((string)($contact['alamat'] ?? $settings['alamat_tpu'] ?? '-'))) ?></p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-telephone fs-5"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Telepon</h6>
                        <p class="text-muted mb-0"><?= esc($contact['telepon'] ?? $settings['telepon_tpu'] ?? '-') ?></p>
                    </div>
                </div>

                <div class="d-flex mb-4">
                    <div class="flex-shrink-0 btn-lg-square rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-envelope fs-5"></i>
                    </div>
                    <div class="ms-3">
                        <h6 class="fw-bold mb-1">Email</h6>
                        <p class="text-muted mb-0"><?= esc($contact['email'] ?? $settings['email_tpu'] ?? '-') ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left">
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-5">
                        <h3 class="fw-bold mb-4">Kirim Pesan</h3>

                        <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success border-0 rounded-pill px-4 mb-4">
                                <i class="bi bi-check-circle-fill me-2"></i> <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger border-0 rounded-pill px-4 mb-4">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('errors')) : ?>
                            <div class="alert alert-danger border-0 rounded-4 px-4 mb-4">
                                <ul class="mb-0 list-unstyled">
                                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                        <li><i class="bi bi-x-circle me-2"></i> <?= esc($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('contact/submit') ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Anda" value="<?= old('name') ?>" required>
                                        <label for="name">Nama Lengkap</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email Anda" value="<?= old('email') ?>" required>
                                        <label for="email">Alamat Email</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subjek" value="<?= old('subject') ?>" required>
                                        <label for="subject">Subjek</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" name="message" placeholder="Pesan Anda" id="message" style="height: 150px" required><?= old('message') ?></textarea>
                                        <label for="message">Pesan</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <!-- Turnstile Widget -->
                                    <?php $turnstileSiteKey = env('TURNSTILE_SITE_KEY'); ?>
                                    <?php if (!empty($turnstileSiteKey)): ?>
                                        <div class="cf-turnstile mb-3" data-sitekey="<?= esc($turnstileSiteKey) ?>" data-width="flexible"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-primary w-100 py-3 rounded-pill shadow-sm fw-bold" type="submit">
                                        <i class="bi bi-send me-2"></i>Kirim Pesan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if (!empty($contact['maps_embed'])): ?>
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12">
                <div class="rounded-4 overflow-hidden shadow-sm" style="height: 400px;">
                    <?= $contact['maps_embed'] ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '<?= session()->getFlashdata('success') ?>',
                confirmButtonColor: '#2c4f7c',
                timer: 5000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '<?= session()->getFlashdata('error') ?>',
                confirmButtonColor: '#2c4f7c'
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>
