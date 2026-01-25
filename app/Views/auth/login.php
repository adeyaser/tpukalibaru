<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= get_setting('site_title', 'SI-MAKAM') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a365d 0%, #2d3748 50%, #1a365d 100%);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }
        
        .login-header {
            background: linear-gradient(135deg, #1a365d 0%, #3182ce 100%);
            padding: 3rem 2rem;
            text-align: center;
            color: white;
        }
        
        .login-header .logo-icon {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
        }
        
        .login-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .login-header p {
            opacity: 0.9;
            margin: 0;
        }
        
        .login-body {
            padding: 2.5rem;
        }
        
        .form-floating {
            margin-bottom: 1.25rem;
        }
        
        .form-floating > .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding-left: 3.5rem !important;
            height: calc(3.5rem + 2px);
            transition: all 0.3s;
        }
        
        .form-floating input:focus {
            border-color: #3182ce;
            box-shadow: 0 0 0 4px rgba(49, 130, 206, 0.15);
        }
        
        .form-floating > label {
            padding-left: 3.5rem !important;
        }
        
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-size: 1.2rem;
            z-index: 10;
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-size: 1.2rem;
            z-index: 10;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .password-toggle:hover {
            color: #3182ce;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #1a365d 0%, #3182ce 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
            color: white;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(49, 130, 206, 0.4);
            color: white;
        }
        
        .alert {
            border-radius: 12px;
            border: none;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 1.5rem;
            color: #718096;
            font-size: 0.9rem;
        }

        /* Mobile Responsiveness Fixes */
        @media (max-width: 480px) {
            .login-card {
                margin: 0 10px;
                width: calc(100% - 20px);
            }
            .login-body {
                padding: 1.5rem;
            }
            .login-header {
                padding: 2rem 1.5rem;
            }
            /* Adjust Turnstile container */
            .cf-turnstile {
                transform: scale(0.9);
                transform-origin: left top;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo-icon">
                    <i class="bi bi-tree-fill"></i>
                </div>
                <h1><?= get_setting('nama_tpu') ?: get_setting('site_title') ?: 'SI-MAKAM' ?></h1>
                <p><?= get_setting('site_description') ?: 'Sistem Informasi Pemakaman' ?></p>
            </div>
            
            <div class="login-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= session()->getFlashdata('error') ?></div>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= session()->getFlashdata('success') ?></div>
                    </div>
                <?php endif; ?>
                
                <form action="<?= base_url('login') ?>" method="POST">
                    <?= csrf_field() ?>
                    
                    <div class="form-floating position-relative">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" class="form-control" id="login" name="login" 
                               placeholder="Username atau Email" required 
                               value="<?= old('login') ?>">
                        <label for="login">Username atau Email</label>
                    </div>
                    
                    <div class="form-floating position-relative">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Password" required>
                        <label for="password">Password</label>
                        <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                    </div>

                    <?php $turnstileSiteKey = env('TURNSTILE_SITE_KEY'); ?>
                    <?php if ($turnstileSiteKey): ?>
                        <div class="mb-4">
                            <div class="cf-turnstile" data-sitekey="<?= esc($turnstileSiteKey) ?>" data-width="flexible"></div>
                        </div>
                    <?php endif; ?>
                    
                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                    </button>
                </form>
                
                <p class="footer-text">
                    &copy; <?= date('Y') ?> <?= get_setting('nama_tpu') ?: get_setting('site_title') ?: 'SI-MAKAM' ?>. All rights reserved.
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function (e) {
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
