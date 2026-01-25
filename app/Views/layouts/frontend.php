<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= esc($settings['site_description'] ?? $settings['nama_tpu'] ?? 'SI-MAKAM') ?> - Tempat Peristirahatan Terakhir yang Damai dan Terhormat">
    <title><?= isset($title) ? esc($title) . ' - ' : '' ?><?= esc($settings['site_title'] ?? $settings['nama_tpu'] ?? 'SI-MAKAM') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts - Poppins (Elegant, Clean, Modern) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo-bekasi.jpg') ?>" type="image/x-icon">
    
    <style>
        :root {
            /* Palette: Serenity & Elegance */
            --primary: #2c4f7c;      /* Calming Navy */
            --primary-dark: #1a365d; /* Deep Navy */
            --primary-light: #4a6fa5;/* Soft Blue */
            --secondary: #334e68;    /* Slate */
            --accent: #c5a47e;       /* Muted Gold/Sand - More natural than bright gold */
            --gold: #d4af37;         /* Classic Gold for small highlights */
            --light: #f8f9fa;
            --soft-bg: #fdfbf7;      /* Warm White/Paper */
            --text-dark: #2d3748;
            --text-muted: #718096;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            line-height: 1.8;
            background-color: var(--soft-bg);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: -0.5px;
        }
        
        /* Elegant Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-light);
        }

        /* Navbar */
        .navbar-custom {
            background: transparent;
            padding: 2rem 0;
            transition: all 0.4s ease;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.05);
        }
        
        .navbar-custom.scrolled .nav-link {
            color: var(--text-dark) !important;
        }
        
        .navbar-custom.scrolled .navbar-brand-custom {
            color: var(--primary-dark) !important;
        }
        
        .navbar-custom.scrolled .navbar-toggler-icon {
             background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 0, 0, 0.55)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        .navbar-custom.scrolled .btn-login {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }

        .navbar-custom .nav-link {
            color: white !important; /* Default white on hero */
            font-weight: 500;
            padding: 0.5rem 1.5rem !important;
            transition: all 0.3s;
            position: relative;
            letter-spacing: 0.5px;
            font-size: 0.95rem;
        }

        /* Scrolled state override handled above */
        
        .navbar-custom .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--accent);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
        }
        
        .navbar-custom .nav-link:hover::after,
        .navbar-custom .nav-link.active::after {
            width: 80%;
        }
        
        .navbar-brand-custom {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 700;
            color: white !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Footer Elegant */
        footer {
            background: var(--primary-dark) !important;
        }
        
        /* Specific Styles from index.php */
        <?= $this->renderSection('styles') ?>
        
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top <?= uri_string() == '/' || uri_string() == '' ? '' : 'scrolled' ?>">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="<?= base_url() ?>">
                <?php if (!empty($settings['site_logo'])): ?>
                    <img src="<?= base_url('uploads/settings/' . $settings['site_logo']) ?>" height="40" alt="Logo">
                <?php else: ?>
                    <i class="bi bi-tree-fill text-gold"></i>
                <?php endif; ?>
                <?= esc($settings['nama_tpu'] ?? $settings['site_title'] ?? 'SI-MAKAM') ?>
            </a>
            <button class="navbar-toggler navbar-dark border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url() ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'services' ? 'active' : '' ?>" href="<?= base_url('services') ?>">Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'gallery' ? 'active' : '' ?>" href="<?= base_url('gallery') ?>">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Kontak</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="<?= base_url('login') ?>" class="btn btn-outline-light rounded-pill px-4 btn-login">Login Area</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?= $this->renderSection('content') ?>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-3 mt-5">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6">
                    <h4 class="mb-4 font-playfair footer-brand">
                        <?php if (!empty($settings['site_logo'])): ?>
                            <img src="<?= base_url('uploads/settings/' . $settings['site_logo']) ?>" height="30" alt="Logo" class="me-2">
                        <?php endif; ?>
                        <?= esc($settings['nama_tpu'] ?? $settings['site_title'] ?? 'SI-MAKAM') ?>
                    </h4>
                    <p class="text-white-50 mb-4"><?= esc((string)($settings['site_description'] ?? 'Tempat Peristirahatan Terakhir yang Damai dan Terhormat.')) ?></p>
                    <div class="social-links d-flex gap-3">
                        <a href="<?= esc($contact['facebook'] ?? '#') ?>" class="text-white"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="<?= esc($contact['instagram'] ?? '#') ?>" class="text-white"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube fs-5"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white mb-4">Link Cepat</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="<?= base_url() ?>" class="text-white-50 text-decoration-none">Beranda</a></li>
                        <li class="mb-2"><a href="<?= base_url('about') ?>" class="text-white-50 text-decoration-none">Tentang Kami</a></li>
                        <li class="mb-2"><a href="<?= base_url('services') ?>" class="text-white-50 text-decoration-none">Layanan</a></li>
                        <li class="mb-2"><a href="<?= base_url('gallery') ?>" class="text-white-50 text-decoration-none">Galeri</a></li>
                        <li class="mb-2"><a href="<?= base_url('contact') ?>" class="text-white-50 text-decoration-none">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Layanan</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Pemakaman Muslim</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Pemakaman Kristen</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Rumah Duka</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Krematorium</a></li>
                        <li class="mb-2"><a href="#" class="text-white-50 text-decoration-none">Perawatan Makam</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-white mb-4">Kontak Kami</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3 d-flex gap-3">
                            <img src="<?= base_url('assets/img/logo-bekasi.jpg') ?>" alt="Logo Bekasi" style="width: 24px; height: 30px; object-fit: contain;" class="mt-1">
                            <span><?= nl2br(esc((string)($contact['alamat'] ?? $settings['alamat_tpu'] ?? 'Menara 165, Bekasi'))) ?></span>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-telephone text-gold mt-1"></i>
                            <span><?= esc($contact['telepon'] ?? $settings['telepon_tpu'] ?? '021-12345678') ?></span>
                        </li>
                        <li class="mb-3 d-flex gap-3">
                            <i class="bi bi-envelope text-gold mt-1"></i>
                            <span><?= esc($contact['email'] ?? $settings['email_tpu'] ?? 'info@simakam.id') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary pt-4 text-center text-white-50">
                <p class="mb-0">&copy; <?= date('Y') ?> <?= esc($settings['nama_tpu'] ?? $settings['site_title'] ?? 'SI-MAKAM') ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true
        });

        // Navbar scroll effect
        const isHomepage = <?= (uri_string() == '/' || uri_string() == '') ? 'true' : 'false' ?>;
        
        if (isHomepage) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 50) {
                    document.querySelector('.navbar-custom').classList.add('scrolled');
                } else {
                    document.querySelector('.navbar-custom').classList.remove('scrolled');
                }
            });
        }
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
