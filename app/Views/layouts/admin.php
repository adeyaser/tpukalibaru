<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="SI-MAKAM - Sistem Informasi Pemakaman">
    <title><?= $title ?? 'Dashboard' ?> - <?= get_setting('site_title', 'SI-MAKAM') ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css">
    
    <style>
        :root {
            --primary-color: #1a365d;
            --primary-dark: #0f2544;
            --secondary-color: #2d3748;
            --accent-color: #3182ce;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
        }
        
        * {
            scrollbar-width: thin;
            scrollbar-color: var(--accent-color) transparent;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8ec 100%);
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }
        
        .sidebar-brand {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }
        
        .sidebar-brand h4 {
            color: white;
            font-weight: 700;
            margin: 0;
            white-space: nowrap;
            transition: opacity 0.3s;
        }
        
        .sidebar.collapsed .sidebar-brand h4,
        .sidebar.collapsed .menu-text,
        .sidebar.collapsed .submenu {
            display: none;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
            flex-grow: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .sidebar-menu::-webkit-scrollbar {
             width: 5px;
        }
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.2); 
            border-radius: 3px;
        }
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .menu-item {
            position: relative;
        }
        
        .menu-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1.5rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            gap: 12px;
        }
        
        .menu-link:hover,
        .menu-link.active {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        
        .menu-link.active {
            border-left: 4px solid var(--accent-color);
            background: rgba(49, 130, 206, 0.2);
        }
        
        .menu-link i {
            font-size: 1.2rem;
            width: 24px;
            text-align: center;
        }
        
        .submenu {
            background: rgba(0,0,0,0.15);
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        
        .submenu.show {
            max-height: 500px;
        }
        
        .submenu .menu-link {
            padding-left: 3.5rem;
            font-size: 0.9rem;
        }
        
        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 0;
            transition: all 0.3s ease;
            min-height: 100vh;
        }
        
        .sidebar.collapsed + .main-content {
            margin-left: var(--sidebar-collapsed);
        }
        
        /* Top Navbar */
        .top-navbar {
            background: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .toggle-sidebar {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            transition: color 0.2s;
        }
        
        .toggle-sidebar:hover {
            color: var(--accent-color);
        }
        
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
            border: none;
            transition: all 0.2s;
        }
        
        .user-dropdown .dropdown-toggle:hover {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent-color);
        }
        
        /* Content Area */
        .content-area {
            padding: 1.5rem;
        }
        
        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            padding: 1rem 1.5rem;
        }
        
        /* Stats Cards */
        .stat-card {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .stat-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3rem;
            opacity: 0.3;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            transition: all 0.2s;
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(49, 130, 206, 0.4);
        }
        
        /* Tables */
        .table thead th {
            background: var(--primary-color);
            color: white;
            font-weight: 600;
            border: none;
        }
        
        .table tbody tr:hover {
            background-color: rgba(49, 130, 206, 0.05);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
                width: var(--sidebar-width);
            }
            
            .main-content {
                margin-left: 0 !important;
            }
            
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            
            .sidebar.show + .sidebar-overlay {
                display: block;
            }
        }
        
        /* Animation */
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <?php helper('acl'); ?>
    
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <?php if (get_setting('site_logo')): ?>
                <img src="<?= base_url('uploads/settings/' . get_setting('site_logo')) ?>" alt="Logo" style="max-height: 30px; width: auto;">
            <?php else: ?>
                <i class="bi bi-tree-fill text-white fs-3"></i>
            <?php endif; ?>
            <h4><?= get_setting('nama_tpu') ?: get_setting('site_title') ?: 'SI-MAKAM' ?></h4>
        </div>
        
        <nav class="sidebar-menu">
            <?php 
            $menus = get_user_menus();
            $currentUrl = uri_string();
            
            foreach ($menus as $menu): 
                $hasChildren = isset($menu['children']) && !empty($menu['children']);
                $isActive = ($currentUrl === $menu['url'] || str_starts_with($currentUrl, $menu['url'] . '/'));
                
                // Check if any child is active
                $childActive = false;
                if ($hasChildren) {
                    foreach ($menu['children'] as $child) {
                        if ($currentUrl === $child['url'] || str_starts_with($currentUrl, $child['url'] . '/')) {
                            $childActive = true;
                            break;
                        }
                    }
                }
                
                // Icon handling
                $iconClass = $menu['icon'] ?: 'bi-circle';
                $iconPrefix = str_starts_with($iconClass, 'fa') ? '' : 'bi';
                $finalIconClass = $iconPrefix ? "$iconPrefix $iconClass" : $iconClass;
            ?>
                <div class="menu-item">
                    <a href="<?= $hasChildren ? '#' : base_url($menu['url']) ?>" 
                       class="menu-link <?= ($isActive || $childActive) ? 'active' : '' ?>"
                       <?= $hasChildren ? 'data-bs-toggle="collapse" data-bs-target="#submenu-' . $menu['id'] . '"' : '' ?>>
                        <i class="<?= $finalIconClass ?>"></i>
                        <span class="menu-text"><?= esc($menu['nama_menu']) ?></span>
                        <?php if ($hasChildren): ?>
                            <i class="bi bi-chevron-down ms-auto menu-text"></i>
                        <?php endif; ?>
                    </a>
                    
                    <?php if ($hasChildren): ?>
                        <div class="submenu collapse <?= $childActive ? 'show' : '' ?>" id="submenu-<?= $menu['id'] ?>">
                            <?php foreach ($menu['children'] as $child): 
                                $childIsActive = ($currentUrl === $child['url'] || str_starts_with($currentUrl, $child['url'] . '/'));
                                $childHasChildren = isset($child['children']) && !empty($child['children']);
                                
                                // Child Icon handling
                                $cIconClass = $child['icon'] ?: 'bi-circle';
                                $cIconPrefix = str_starts_with($cIconClass, 'fa') ? '' : 'bi';
                                $cFinalIconClass = $cIconPrefix ? "$cIconPrefix $cIconClass" : $cIconClass;

                                if ($childHasChildren):
                                    // Check if any grandchild is active
                                    $grandChildActive = false;
                                    foreach ($child['children'] as $grandChild) {
                                        if ($currentUrl === $grandChild['url'] || str_starts_with($currentUrl, $grandChild['url'] . '/')) {
                                            $grandChildActive = true;
                                            break;
                                        }
                                    }
                            ?>
                                <div class="menu-item ps-3">
                                    <a href="#" 
                                       class="menu-link <?= ($childIsActive || $grandChildActive) ? 'active' : '' ?>"
                                       data-bs-toggle="collapse" data-bs-target="#submenu-<?= $child['id'] ?>">
                                        <i class="<?= $cFinalIconClass ?>"></i>
                                        <span class="menu-text"><?= esc($child['nama_menu']) ?></span>
                                        <i class="bi bi-chevron-down ms-auto menu-text"></i>
                                    </a>
                                    
                                    <div class="submenu collapse <?= $grandChildActive ? 'show' : '' ?>" id="submenu-<?= $child['id'] ?>">
                                        <?php foreach ($child['children'] as $grandChild):
                                            $grandChildIsActive = ($currentUrl === $grandChild['url'] || str_starts_with($currentUrl, $grandChild['url'] . '/'));
                                            $gcIconClass = $grandChild['icon'] ?: 'bi-circle';
                                            $gcIconPrefix = str_starts_with($gcIconClass, 'fa') ? '' : 'bi';
                                            $gcFinalIconClass = $gcIconPrefix ? "$gcIconPrefix $gcIconClass" : $gcIconClass;
                                        ?>
                                            <a href="<?= base_url($grandChild['url']) ?>" 
                                               class="menu-link <?= $grandChildIsActive ? 'active' : '' ?>" style="padding-left: 3rem;">
                                                <i class="<?= $gcFinalIconClass ?>"></i>
                                                <span class="menu-text"><?= esc($grandChild['nama_menu']) ?></span>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a href="<?= base_url($child['url']) ?>" 
                                   class="menu-link <?= $childIsActive ? 'active' : '' ?>">
                                    <i class="<?= $cFinalIconClass ?>"></i>
                                    <span class="menu-text"><?= esc($child['nama_menu']) ?></span>
                                </a>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </nav>
    </aside>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Navbar -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="toggle-sidebar" id="toggleSidebar">
                    <i class="bi bi-list"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                        <?php if (isset($breadcrumb)): ?>
                            <?php foreach ($breadcrumb as $item): ?>
                                <li class="breadcrumb-item <?= $item['active'] ? 'active' : '' ?>">
                                    <?php if ($item['active']): ?>
                                        <?= esc($item['title']) ?>
                                    <?php else: ?>
                                        <a href="<?= $item['url'] ?>"><?= esc($item['title']) ?></a>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
            
            <div class="user-dropdown dropdown">
                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php $user = current_user(); ?>
                    <img src="<?= $user['foto'] ? base_url('uploads/users/' . $user['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($user['nama_lengkap']) . '&background=1a365d&color=fff' ?>" 
                         alt="Avatar" class="user-avatar">
                    <span class="d-none d-md-inline"><?= esc($user['nama_lengkap']) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                </ul>
            </div>
        </header>
        
        <!-- Content Area -->
        <div class="content-area">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?= $this->renderSection('content') ?>
        </div>
    </main>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    
    <script>
        // Toggle Sidebar
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('show');
            } else {
                sidebar.classList.toggle('collapsed');
            }
        });
        
        // Close sidebar on mobile when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('show');
        });
        
        // Initialize DataTables
        $(document).ready(function() {
            if ($('.datatable').length) {
                $('.datatable').DataTable({
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "Selanjutnya",
                            previous: "Sebelumnya"
                        },
                        emptyTable: "Tidak ada data tersedia",
                        zeroRecords: "Tidak ada data yang cocok"
                    }
                });
            }
        });
        
        // Delete Confirmation
        function confirmDelete(url, title = 'data ini') {
            Swal.fire({
                title: 'Yakin hapus ' + title + '?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>
