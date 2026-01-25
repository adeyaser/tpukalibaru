<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes - Company Profile
$routes->get('/', 'Compro::index');
$routes->get('/about', 'Compro::about');
$routes->get('/services', 'Compro::services');
$routes->get('/gallery', 'Compro::gallery');
$routes->get('/gallery', 'Compro::gallery');
$routes->get('/contact', 'Compro::contact');
$routes->post('/contact/submit', 'Compro::submitMessage');
// $routes->get('/debug-menu', 'DebugMenu::index');

// Auth routes
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

// Admin routes - Protected by auth filter
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // Dashboard
    $routes->get('/dashboard', 'Dashboard::index');
    
    // Users Management
    $routes->get('/users', 'Users::index');
    $routes->get('/users/create', 'Users::create');
    $routes->post('/users/store', 'Users::store');
    $routes->get('/users/edit/(:num)', 'Users::edit/$1');
    $routes->post('/users/update/(:num)', 'Users::update/$1');
    $routes->post('/users/delete/(:num)', 'Users::delete/$1');
    
    // Groups Management
    $routes->get('/groups', 'Groups::index');
    $routes->get('/groups/create', 'Groups::create');
    $routes->post('/groups/store', 'Groups::store');
    $routes->get('/groups/edit/(:num)', 'Groups::edit/$1');
    $routes->post('/groups/update/(:num)', 'Groups::update/$1');
    $routes->post('/groups/delete/(:num)', 'Groups::delete/$1');
    $routes->get('/groups/permissions/(:num)', 'Groups::permissions/$1');
    $routes->post('/groups/permissions/(:num)', 'Groups::savePermissions/$1');
    
    // Menus Management
    $routes->get('/menus', 'Menus::index');
    $routes->get('/menus/create', 'Menus::create');
    $routes->post('/menus/store', 'Menus::store');
    $routes->get('/menus/edit/(:num)', 'Menus::edit/$1');
    $routes->post('/menus/update/(:num)', 'Menus::update/$1');
    $routes->post('/menus/delete/(:num)', 'Menus::delete/$1');
    
    // Lokasi Makam
    $routes->get('/lokasi-makam', 'LokasiMakam::index');
    $routes->get('/lokasi-makam/create', 'LokasiMakam::create');
    $routes->post('/lokasi-makam/store', 'LokasiMakam::store');
    $routes->get('/lokasi-makam/edit/(:num)', 'LokasiMakam::edit/$1');
    $routes->post('/lokasi-makam/update/(:num)', 'LokasiMakam::update/$1');
    $routes->post('/lokasi-makam/delete/(:num)', 'LokasiMakam::delete/$1');
    
    // Jenazah
    $routes->get('/jenazah', 'Jenazah::index');
    $routes->get('/jenazah/create', 'Jenazah::create');
    $routes->post('/jenazah/store', 'Jenazah::store');
    $routes->get('/jenazah/view/(:num)', 'Jenazah::view/$1');
    $routes->get('/jenazah/edit/(:num)', 'Jenazah::edit/$1');
    $routes->post('/jenazah/update/(:num)', 'Jenazah::update/$1');
    $routes->post('/jenazah/delete/(:num)', 'Jenazah::delete/$1');
    
    // Keluarga Jenazah
    $routes->get('/keluarga', 'KeluargaJenazah::index');
    $routes->get('/keluarga/create', 'KeluargaJenazah::create');
    $routes->get('/keluarga/create/(:num)', 'KeluargaJenazah::create/$1');
    $routes->post('/keluarga/store', 'KeluargaJenazah::store');
    $routes->get('/keluarga/edit/(:num)', 'KeluargaJenazah::edit/$1');
    $routes->post('/keluarga/update/(:num)', 'KeluargaJenazah::update/$1');
    $routes->post('/keluarga/delete/(:num)', 'KeluargaJenazah::delete/$1');
    
    // Pemakaman
    $routes->get('/pemakaman', 'Pemakaman::index');
    $routes->get('/pemakaman/create', 'Pemakaman::create');
    $routes->post('/pemakaman/store', 'Pemakaman::store');
    $routes->get('/pemakaman/view/(:num)', 'Pemakaman::view/$1');
    $routes->get('/pemakaman/edit/(:num)', 'Pemakaman::edit/$1');
    $routes->post('/pemakaman/update/(:num)', 'Pemakaman::update/$1');
    $routes->post('/pemakaman/delete/(:num)', 'Pemakaman::delete/$1');
    
    // Perawatan Makam
    $routes->get('/perawatan', 'PerawatanMakam::index');
    $routes->get('/perawatan/create', 'PerawatanMakam::create');
    $routes->post('/perawatan/store', 'PerawatanMakam::store');
    $routes->get('/perawatan/edit/(:num)', 'PerawatanMakam::edit/$1');
    $routes->post('/perawatan/update/(:num)', 'PerawatanMakam::update/$1');
    $routes->post('/perawatan/delete/(:num)', 'PerawatanMakam::delete/$1');
    
    // Tagihan Keluarga
    $routes->get('/tagihan', 'TagihanKeluarga::index');
    $routes->get('/tagihan/create', 'TagihanKeluarga::create');
    $routes->post('/tagihan/store', 'TagihanKeluarga::store');
    $routes->get('/tagihan/view/(:num)', 'TagihanKeluarga::view/$1');
    $routes->get('/tagihan/pdf/(:num)', 'TagihanKeluarga::pdf/$1');
    $routes->get('/tagihan/edit/(:num)', 'TagihanKeluarga::edit/$1');
    $routes->post('/tagihan/update/(:num)', 'TagihanKeluarga::update/$1');
    $routes->post('/tagihan/delete/(:num)', 'TagihanKeluarga::delete/$1');
    
    // Pembayaran
    $routes->get('/pembayaran', 'Pembayaran::index');
    $routes->get('/pembayaran/create/(:num)', 'Pembayaran::create/$1');
    $routes->post('/pembayaran/store', 'Pembayaran::store');
    $routes->get('/pembayaran/view/(:num)', 'Pembayaran::view/$1');
    $routes->post('/pembayaran/delete/(:num)', 'Pembayaran::delete/$1');
    
    // Pengeluaran
    $routes->get('/pengeluaran', 'Pengeluaran::index');
    $routes->get('/pengeluaran/create', 'Pengeluaran::create');
    $routes->post('/pengeluaran/store', 'Pengeluaran::store');
    $routes->get('/pengeluaran/edit/(:num)', 'Pengeluaran::edit/$1');
    $routes->post('/pengeluaran/update/(:num)', 'Pengeluaran::update/$1');
    $routes->post('/pengeluaran/delete/(:num)', 'Pengeluaran::delete/$1');
    
    // Pembelian Alat
    $routes->get('/pembelian', 'PembelianAlat::index');
    $routes->get('/pembelian/create', 'PembelianAlat::create');
    $routes->post('/pembelian/store', 'PembelianAlat::store');
    $routes->get('/pembelian/edit/(:num)', 'PembelianAlat::edit/$1');
    $routes->post('/pembelian/update/(:num)', 'PembelianAlat::update/$1');
    $routes->post('/pembelian/delete/(:num)', 'PembelianAlat::delete/$1');
    
    // Karyawan
    $routes->get('/karyawan', 'Karyawan::index');
    $routes->get('/karyawan/create', 'Karyawan::create');
    $routes->post('/karyawan/store', 'Karyawan::store');
    $routes->get('/karyawan/view/(:num)', 'Karyawan::view/$1');
    $routes->get('/karyawan/edit/(:num)', 'Karyawan::edit/$1');
    $routes->post('/karyawan/update/(:num)', 'Karyawan::update/$1');
    $routes->post('/karyawan/delete/(:num)', 'Karyawan::delete/$1');
    
    // Tunjangan
    $routes->get('/tunjangan', 'Tunjangan::index');
    $routes->get('/tunjangan/create', 'Tunjangan::create');
    $routes->post('/tunjangan/store', 'Tunjangan::store');
    $routes->get('/tunjangan/edit/(:num)', 'Tunjangan::edit/$1');
    $routes->post('/tunjangan/update/(:num)', 'Tunjangan::update/$1');
    $routes->post('/tunjangan/delete/(:num)', 'Tunjangan::delete/$1');
    
    // Gaji
    $routes->get('/gaji', 'Gaji::index');
    $routes->get('/gaji/create', 'Gaji::create');
    $routes->post('/gaji/store', 'Gaji::store');
    $routes->get('/gaji/view/(:num)', 'Gaji::view/$1');
    $routes->get('/gaji/edit/(:num)', 'Gaji::edit/$1');
    $routes->post('/gaji/update/(:num)', 'Gaji::update/$1');
    $routes->post('/gaji/delete/(:num)', 'Gaji::delete/$1');
    $routes->post('/gaji/bayar/(:num)', 'Gaji::bayar/$1');
    $routes->get('/gaji/print/(:num)', 'Gaji::print/$1');
    
    // Reports
    $routes->get('/reports/pemakaman', 'Reports::pemakaman');
    $routes->get('/reports/perawatan', 'Reports::perawatan');
    $routes->get('/reports/keuangan', 'Reports::keuangan');
    $routes->get('/reports/export/(:segment)', 'Reports::export/$1');
    
    // Settings (General)
    $routes->get('/settings', 'Settings::index');
    $routes->post('/settings/update', 'Settings::update');

    // Company Profile Settings (CMS)
    $routes->get('/compro-settings', 'ComproSettings::index');

    $routes->get('/compro-settings/hero', 'ComproSettings::hero');
    $routes->post('/compro-settings/hero/update', 'ComproSettings::updateHero');

    $routes->get('/compro-settings/about', 'ComproSettings::about');
    $routes->post('/compro-settings/about/update', 'ComproSettings::updateAbout');

    $routes->get('/compro-settings/contact', 'ComproSettings::contact');
    $routes->post('/compro-settings/contact/update', 'ComproSettings::updateContact');

    $routes->get('/compro-settings/services', 'ComproSettings::services');
    $routes->get('/compro-settings/services/create', 'ComproSettings::createService');
    $routes->post('/compro-settings/services/store', 'ComproSettings::storeService');
    $routes->get('/compro-settings/services/edit/(:num)', 'ComproSettings::editService/$1');
    $routes->post('/compro-settings/services/update/(:num)', 'ComproSettings::updateService/$1');
    $routes->get('/compro-settings/services/delete/(:num)', 'ComproSettings::deleteService/$1');

    $routes->get('/compro-settings/gallery', 'ComproSettings::gallery');
    $routes->get('/compro-settings/gallery/create', 'ComproSettings::createGallery');
    $routes->post('/compro-settings/gallery/store', 'ComproSettings::storeGallery');
    $routes->get('/compro-settings/gallery/delete/(:num)', 'ComproSettings::deleteGallery/$1');

    $routes->get('/compro-settings/testimonials', 'ComproSettings::testimonials'); // Index for testimonials
    $routes->get('/compro-settings/testimonials/create', 'ComproSettings::createTestimonial'); // Create Form - WARNING: Controller method name check needed
    $routes->post('/compro-settings/testimonials/store', 'ComproSettings::storeTestimonial');
    $routes->get('/compro-settings/testimonials/edit/(:num)', 'ComproSettings::editTestimonial/$1'); // Edit Form
    $routes->post('/compro-settings/testimonials/update/(:num)', 'ComproSettings::updateTestimonial/$1');
    $routes->get('/compro-settings/testimonials/delete/(:num)', 'ComproSettings::deleteTestimonial/$1');
    
    $routes->get('/compro-settings/messages', 'ComproSettings::messages');
    $routes->get('/compro-settings/messages/view/(:num)', 'ComproSettings::viewMessage/$1');
    $routes->get('/compro-settings/messages/delete/(:num)', 'ComproSettings::deleteMessage/$1');
    $routes->get('/compro-settings/testimonials/delete/(:num)', 'ComproSettings::deleteTestimonial/$1');
    
    // Debug
    // $routes->get('/debug-menu', 'DebugMenu::index');
});
