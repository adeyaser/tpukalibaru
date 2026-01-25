<?= $this->extend('layouts/frontend') ?>

<?= $this->section('styles') ?>
        /* Hero Section - Serene & Heavenly */
        .hero-section {
            min-height: 100vh;
            /* Reduced opacity for "lighter fog", letting earth tones show */
            background: linear-gradient(180deg, rgba(26, 54, 93, 0.3) 0%, rgba(26, 54, 93, 0.1) 100%),
                        url('<?= base_url('uploads/compro/' . ($hero['background_image'] ?? 'hero-bg.jpg')) ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 15rem;
            background: linear-gradient(to top, var(--soft-bg), transparent);
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            padding-top: 3rem;
        }

        .hero-content h1 {
            font-size: 5rem;
            margin-bottom: 1rem;
            color: #ffffff;
            /* White text with Black Border (Stroke effect via Shadow) */
            text-shadow: 
               -2px -2px 0 #000,  
                2px -2px 0 #000,
               -2px  2px 0 #000,
                2px  2px 0 #000,
                0 5px 15px rgba(0,0,0,0.5);
            letter-spacing: -2px;
            font-weight: 800;
        }
        
        .hero-content h5 {
            color: #ffffff;
            font-weight: 700;
            /* Thinner black border for smaller text */
            text-shadow: 
               -1px -1px 0 #000,  
                1px -1px 0 #000,
               -1px  1px 0 #000,
                1px  1px 0 #000;
        }
        
        .hero-content p {
            font-size: 1.5rem;
            max-width: 800px;
            margin: 0 auto 2.5rem;
            color: #f8f9fa;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            font-weight: 400;
            letter-spacing: 0.5px;
        }
        
        .btn-hero {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.4s ease;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9rem;
        }
        
        .btn-hero:hover {
            background: white;
            color: var(--primary-dark);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .btn-hero.active {
            background: white;
            color: var(--primary-dark);
            border-color: white;
        }
        
        /* Section Styling */
        .section-padding {
            padding: 120px 0; /* More breathing room */
        }
        
        .section-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--primary-dark);
        }
        
        .section-subtitle {
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: inline-block;
        }
        
        .gold-line {
            width: 80px;
            height: 3px;
            background: var(--accent);
            margin: 1.5rem auto 3rem;
            border-radius: 100px;
            position: relative;
        }
        .gold-line::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            background: var(--accent);
            border-radius: 50%;
            border: 2px solid white;
        }
        
        /* Stats Cards - Elegant Float */
        .stats-section {
            margin-top: -100px; /* Overlap hero */
            position: relative;
            z-index: 10;
            padding-bottom: 40px;
        }
        
        .stat-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 16px; /* More visible rounded corners */
            text-align: center;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08); /* Deep soft shadow */
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-bottom: 4px solid var(--accent);
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 30px 60px rgba(0,0,0,0.12);
        }
        
        .stat-number {
             font-size: 3.5rem;
             font-weight: 700;
             color: var(--primary-dark);
             font-family: 'Poppins', sans-serif;
             margin-bottom: 0.5rem;
             line-height: 1;
        }
        
        /* About Section */
        .about-section {
            background: var(--soft-bg);
            position: relative;
        }
        /* Pattern Overlay */
        .pattern-bg {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0.03;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%231a365d' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .about-image-wrapper {
             position: relative;
        }
        .about-image {
            border-radius: 4px;
            box-shadow: 20px 20px 0 var(--accent), 0 0 50px rgba(0,0,0,0.1);
            position: relative;
            z-index: 2;
        }
        .about-image img {
            border-radius: 4px;
            width: 100%;
            height: 500px;
            object-fit: cover;
            filter: brightness(95%) contrast(105%);
        }
        
        /* Services - Clean & Minimal */
        .service-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: 8px;
            text-align: center;
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.4s;
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.06);
            border-color: transparent;
        }
        
        .service-icon-box {
            width: 70px;
            height: 70px;
            background: var(--soft-bg);
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
            transition: all 0.3s;
        }
        
        .service-card:hover .service-icon-box {
            background: var(--primary);
            color: white;
        }
        
        /* CTA Section */
        .cta-section {
            background-color: var(--primary-dark);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        
        /* Gallery */
        .gallery-item {
            display: block;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }
        
        .gallery-item img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            transition: transform 0.7s ease;
        }
        
        .gallery-item:hover img {
            transform: scale(1.08);
        }
        
        .gallery-overlay {
            background: linear-gradient(to top, rgba(15, 37, 68, 0.9), transparent);
            padding: 2rem;
            display: flex;
            align-items: flex-end;
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 0.4s;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Hero Section -->
    <section class="hero-section text-white text-center">
        <div class="container hero-content" data-aos="fade-up">

            <h1 class="display-3 mb-4 fw-bold"><?= esc($hero['judul'] ?? 'Solusi Pemakaman Terpercaya') ?></h1>
            <p class="lead mb-5 mx-auto" style="max-width: 700px;"><?= esc($hero['subjudul'] ?? 'Memberikan pelayanan terbaik dengan penuh kehormatan dan ketenangan bagi keluarga dan orang terkasih.') ?></p>
            <div class="d-flex gap-3 justify-content-center">
                <a href="<?= esc($hero['cta_url'] ?? '#contact') ?>" class="btn-hero active"><?= esc($hero['cta_text'] ?? 'Hubungi Kami') ?></a>
                <a href="#services" class="btn-hero">Layanan Kami</a>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="container stats-section">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="stat-card">
                    <div class="stat-number mb-2"><?= $stats['tahun_beroperasi'] ?? '10' ?>+</div>
                    <div class="text-uppercase letter-spacing-2 text-muted small fw-bold">Tahun Pengalaman</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card">
                    <div class="stat-number mb-2"><?= number_format($stats['total_makam'] ?? 0) ?>+</div>
                    <div class="text-uppercase letter-spacing-2 text-muted small fw-bold">Kapasitas Makam</div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card">
                    <div class="stat-number mb-2"><?= number_format($stats['total_keluarga'] ?? 0) ?>+</div>
                    <div class="text-uppercase letter-spacing-2 text-muted small fw-bold">Keluarga Terlayani</div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="pattern-bg"></div>
        <div class="container position-relative z-1">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image-wrapper pe-lg-5">
                        <div class="about-image">
                            <img src="<?= base_url('uploads/compro/' . ($about['gambar'] ?? 'about.jpg')) ?>" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <span class="section-subtitle">Tentang Kami</span>
                    <h2 class="section-title text-start mb-4"><?= esc($about['judul'] ?? 'Menghormati Kenangan') ?></h2>
                    <p class="text-muted mb-5 lead fw-light"><?= nl2br(esc($about['deskripsi'] ?? '')) ?></p>
                    
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3"><i class="bi bi-clock-history fs-3"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Siaga 24 Jam</h6>
                                    <p class="small text-muted mb-0">Layanan penerimaan jenazah setiap saat.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 text-primary me-3"><i class="bi bi-flower1 fs-3"></i></div>
                                <div>
                                    <h6 class="fw-bold mb-1">Perawatan Berkala</h6>
                                    <p class="small text-muted mb-0">Jaminan kebersihan makam selamanya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?= base_url('about') ?>" class="btn btn-outline-dark rounded-pill px-5 py-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section-padding bg-light" id="services">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <span class="section-subtitle">Layanan Kami</span>
                <h2>Pelayanan Profesional</h2>
                <p>Kami menyediakan berbagai layanan pemakaman dan perawatan makam untuk ketenangan Anda.</p>
            </div>
            
            <div class="row g-4">
                <?php if (!empty($services)): ?>
                    <?php foreach ($services as $s): ?>
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="service-card">
                            <div class="service-icon-box">
                                <i class="<?= esc($s['icon'] ?? 'bi-tree') ?>"></i>
                            </div>
                            <h4><?= esc($s['nama_layanan']) ?></h4>
                            <p class="text-muted mb-0"><?= esc($s['deskripsi']) ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center text-muted">Belum ada data layanan.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    
    <!-- Gallery Preview -->
    <section class="section-padding">
        <div class="container">
            <div class="d-flex justify-content-between align-items-end mb-5" data-aos="fade-up">
                <div>
                    <span class="section-subtitle">Galeri Foto</span>
                    <h2 class="mb-0">Keindahan Area Makam</h2>
                </div>
                <a href="<?= base_url('gallery') ?>" class="btn btn-outline-primary rounded-pill d-none d-md-block">Lihat Semua Galeri</a>
            </div>
            
            <div class="row g-4">
                <?php if (!empty($gallery)): ?>
                    <?php foreach ($gallery as $g): ?>
                    <div class="col-md-4" data-aos="zoom-in">
                        <a href="<?= base_url('gallery') ?>" class="gallery-item">
                            <img src="<?= base_url('uploads/compro/' . $g['gambar']) ?>" alt="<?= esc($g['judul']) ?>">
                            <div class="gallery-overlay">
                                <h5 class="text-white mb-1"><?= esc($g['judul']) ?></h5>
                                <p class="text-white-50 small mb-0"><?= esc($g['deskripsi']) ?></p>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
            <div class="text-center mt-4 d-md-none">
                 <a href="<?= base_url('gallery') ?>" class="btn btn-outline-primary rounded-pill">Lihat Semua Galeri</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="contact">
        <div class="cta-pattern"></div>
        <div class="container position-relative z-1 text-center">
            <h2 class="display-5 fw-bold mb-4 text-white" data-aos="fade-up">Butuh Bantuan Segera?</h2>
            <p class="lead mb-5 text-white-50" data-aos="fade-up" data-aos-delay="100">Tim kami siap membantu Anda 24 jam sehari, 7 hari seminggu untuk memberikan layanan terbaik.</p>
            <div data-aos="fade-up" data-aos-delay="200">
                <a href="https://wa.me/<?= esc($contact['whatsapp'] ?? '') ?>" class="btn btn-light btn-lg rounded-pill px-5 me-3 mb-3 mb-sm-0 text-primary fw-bold">
                    <i class="bi bi-whatsapp me-2"></i> WhatsApp
                </a>
                <a href="tel:<?= esc($contact['telepon'] ?? '') ?>" class="btn btn-outline-light btn-lg rounded-pill px-5 fw-bold">
                    <i class="bi bi-telephone me-2"></i> Hubungi Kami
                </a>
            </div>
        </div>
    </section>

<?= $this->endSection() ?>
            background: linear-gradient(135deg, rgba(26, 54, 93, 0.9) 0%, rgba(45, 55, 72, 0.85) 100%),
                        url('https://images.unsplash.com/photo-1509099836639-18ba1795216d?q=80&w=2000') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(to top, white, transparent);
        }
        
        .hero-content h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.3);
        }
        
        .hero-content p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            opacity: 0.95;
        }
        
        .btn-hero {
            background: linear-gradient(135deg, var(--gold) 0%, #b78c1f 100%);
            color: white;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            border: none;
        }
        
        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(214, 158, 46, 0.4);
            color: white;
        }
        
        /* Section Styling */
        .section-padding {
            padding: 100px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
        }
        
        .section-subtitle {
            color: #718096;
            margin-bottom: 3rem;
        }
        
        .gold-line {
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--gold) 0%, #b78c1f 100%);
            margin: 1rem auto 2rem;
            border-radius: 2px;
        }
        
        /* About Section */
        .about-section {
            background: #f7fafc;
        }
        
        .about-image {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
        }
        
        .about-image img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        /* Services */
        .service-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.3s;
            height: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, var(--gold) 0%, #b78c1f 100%);
            transform: scaleX(0);
            transition: transform 0.3s;
        }
        
        .service-card:hover::before {
            transform: scaleX(1);
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .service-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
        }
        
        .service-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-top: 1rem;
        }
        
        /* Stats */
        .stats-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .stat-item h3 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--gold);
        }
        
        /* Gallery */
        .gallery-item {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
        }
        
        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-item:hover img {
            transform: scale(1.1);
        }
        
        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26, 54, 93, 0.9), transparent);
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            position: relative;
        }
        
        .testimonial-card::before {
            content: '"';
            font-family: 'Playfair Display', serif;
            font-size: 6rem;
            color: var(--gold);
            opacity: 0.2;
            position: absolute;
            top: 10px;
            left: 20px;
            line-height: 1;
        }
        
        .testimonial-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--gold);
        }
        
        /* Contact */
        .contact-section {
            background: #f7fafc;
        }
        
        .contact-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            height: 100%;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        }
        
        .contact-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
            color: white;
            padding: 60px 0 30px;
        }
        
        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: var(--gold);
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 2rem;
            margin-top: 3rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom" href="<?= base_url() ?>">
                <i class="bi bi-tree-fill"></i>
                <?= esc($settings['nama_tpu'] ?? 'SI-MAKAM') ?>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-3"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active-scroll" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link active-scroll" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link active-scroll" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link active-scroll" href="#gallery">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link active-scroll" href="#contact">Kontak</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-hero py-2 px-4" href="<?= base_url('login') ?>">
                            <i class="bi bi-person"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-content" data-aos="fade-up">
            <h1><?= esc($hero['judul'] ?? 'Selamat Datang') ?></h1>
            <p><?= esc($hero['subjudul'] ?? 'Tempat Peristirahatan Terakhir yang Damai dan Terhormat') ?></p>
            <?php if (!empty($hero['cta_text'])): ?>
                <a href="<?= esc($hero['cta_url'] ?? '#contact') ?>" class="btn-hero">
                    <?= esc($hero['cta_text']) ?>
                    <i class="bi bi-arrow-right"></i>
                </a>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- About Section -->
    <section class="about-section section-padding" id="about">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image">
                        <img src="<?= $about['gambar'] ? base_url('uploads/compro/' . $about['gambar']) : 'https://images.unsplash.com/photo-1516906825668-e2c77c0a3a39?w=600' ?>" 
                             alt="Tentang Kami">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <h2 class="section-title"><?= esc($about['judul'] ?? 'Tentang Kami') ?></h2>
                    <div class="gold-line" style="margin-left: 0;"></div>
                    <p class="lead mb-4"><?= nl2br(esc($about['deskripsi'] ?? '')) ?></p>
                    
                    <?php if (!empty($about['visi'])): ?>
                        <h5 class="mt-4 mb-2"><i class="bi bi-eye text-primary me-2"></i>Visi</h5>
                        <p><?= esc($about['visi']) ?></p>
                    <?php endif; ?>
                    
                    <?php if (!empty($about['misi'])): ?>
                        <h5 class="mt-4 mb-2"><i class="bi bi-bullseye text-primary me-2"></i>Misi</h5>
                        <p><?= nl2br(esc($about['misi'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Stats Section -->
    <section class="stats-section section-padding">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-item">
                        <h3><?= number_format($stats['total_makam'] ?? 0) ?>+</h3>
                        <p class="mb-0 opacity-75">Kapasitas Makam</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <h3><?= $stats['tahun_beroperasi'] ?? 20 ?>+</h3>
                        <p class="mb-0 opacity-75">Tahun Beroperasi</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <h3><?= number_format($stats['total_keluarga'] ?? 0) ?>+</h3>
                        <p class="mb-0 opacity-75">Keluarga Terlayani</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="section-padding" id="services">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Layanan Kami</h2>
                <div class="gold-line"></div>
                <p class="section-subtitle">Kami menyediakan berbagai layanan pemakaman profesional</p>
            </div>
            
            <div class="row g-4">
                <?php foreach ($services as $index => $service): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="bi <?= esc($service['icon'] ?: 'bi-box') ?>"></i>
                            </div>
                            <h4><?= esc($service['nama_layanan']) ?></h4>
                            <p class="text-muted"><?= esc($service['deskripsi']) ?></p>
                            <?php if (!empty($service['harga'])): ?>
                                <p class="service-price">Rp <?= number_format($service['harga'], 0, ',', '.') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Gallery Section -->
    <?php if (!empty($gallery)): ?>
    <section class="section-padding" id="gallery" style="background: #f7fafc;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Galeri Kami</h2>
                <div class="gold-line"></div>
            </div>
            
            <div class="row g-4">
                <?php foreach ($gallery as $index => $item): ?>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="gallery-item">
                            <img src="<?= base_url('uploads/compro/' . $item['gambar']) ?>" alt="<?= esc($item['judul']) ?>">
                            <div class="gallery-overlay">
                                <div class="text-white">
                                    <h5><?= esc($item['judul']) ?></h5>
                                    <p class="small mb-0"><?= esc($item['deskripsi']) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Testimonials Section -->
    <?php if (!empty($testimonials)): ?>
    <section class="section-padding">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Testimoni</h2>
                <div class="gold-line"></div>
                <p class="section-subtitle">Apa kata keluarga yang telah kami layani</p>
            </div>
            
            <div class="row g-4">
                <?php foreach ($testimonials as $index => $t): ?>
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                        <div class="testimonial-card">
                            <p class="mb-4"><?= esc($t['testimoni']) ?></p>
                            <div class="d-flex align-items-center gap-3">
                                <img src="<?= $t['foto'] ? base_url('uploads/compro/' . $t['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($t['nama']) . '&background=1a365d&color=fff' ?>" 
                                     alt="<?= esc($t['nama']) ?>" class="testimonial-avatar">
                                <div>
                                    <h6 class="mb-0"><?= esc($t['nama']) ?></h6>
                                    <small class="text-muted"><?= esc($t['relasi']) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Contact Section -->
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Hubungi Kami</h2>
                <div class="gold-line"></div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="contact-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h5>Alamat</h5>
                        <p class="text-muted mb-0"><?= nl2br(esc($contact['alamat'] ?? '')) ?></p>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="contact-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <h5>Telepon</h5>
                        <p class="mb-1"><?= esc($contact['telepon'] ?? '') ?></p>
                        <?php if (!empty($contact['whatsapp'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $contact['whatsapp']) ?>" class="text-success">
                                <i class="bi bi-whatsapp"></i> WhatsApp
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="contact-card text-center">
                        <div class="contact-icon mx-auto">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <h5>Email</h5>
                        <p class="text-muted mb-0"><?= esc($contact['email'] ?? '') ?></p>
                        <p class="text-muted small mt-2"><?= esc($contact['jam_operasional'] ?? '') ?></p>
                    </div>
                </div>
            </div>
            
            <?php if (!empty($contact['maps_embed'])): ?>
                <div class="mt-5" data-aos="fade-up">
                    <div class="ratio ratio-21x9" style="border-radius: 20px; overflow: hidden;">
                        <?= $contact['maps_embed'] ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h4 class="mb-4"><i class="bi bi-tree-fill me-2"></i><?= esc($settings['nama_tpu'] ?? 'SI-MAKAM') ?></h4>
                    <p class="opacity-75"><?= esc($about['deskripsi'] ?? '') ?></p>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3 text-uppercase">Menu</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#home">Beranda</a></li>
                        <li class="mb-2"><a href="#about">Tentang</a></li>
                        <li class="mb-2"><a href="#services">Layanan</a></li>
                        <li class="mb-2"><a href="#contact">Kontak</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="mb-3 text-uppercase">Layanan</h6>
                    <ul class="list-unstyled">
                        <?php foreach (array_slice($services, 0, 4) as $s): ?>
                            <li class="mb-2"><a href="#services"><?= esc($s['nama_layanan']) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="mb-3 text-uppercase">Kontak</h6>
                    <p class="mb-2"><i class="bi bi-telephone me-2"></i><?= esc($contact['telepon'] ?? '') ?></p>
                    <p class="mb-2"><i class="bi bi-envelope me-2"></i><?= esc($contact['email'] ?? '') ?></p>
                    <div class="mt-3">
                        <?php if (!empty($contact['facebook'])): ?>
                            <a href="<?= esc($contact['facebook']) ?>" class="me-3 fs-4"><i class="bi bi-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($contact['instagram'])): ?>
                            <a href="<?= esc($contact['instagram']) ?>" class="me-3 fs-4"><i class="bi bi-instagram"></i></a>
                        <?php endif; ?>
                        <?php if (!empty($contact['whatsapp'])): ?>
                            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $contact['whatsapp']) ?>" class="fs-4"><i class="bi bi-whatsapp"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom text-center">
                <p class="mb-0 opacity-75">&copy; <?= date('Y') ?> <?= esc($settings['nama_tpu'] ?? 'SI-MAKAM') ?>. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 100) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                    // Close mobile menu if open
                    const navbarCollapse = document.getElementById('navbarNav');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {toggle: true});
                    }
                }
            });
        });

        // ScrollSpy logic
        const sections = document.querySelectorAll('section');
        const navLinks = document.querySelectorAll('.nav-link.active-scroll');

        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href').includes(current)) {
                    link.classList.add('active');
                }
            });
            
            // Special case for top/home
            if (window.scrollY < 100) {
                 navLinks.forEach(link => link.classList.remove('active'));
                 document.querySelector('a[href="#home"]').classList.add('active');
            }
        });
    </script>
</body>
</html>
