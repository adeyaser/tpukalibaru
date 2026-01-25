<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // Create admin group
        $this->db->table('groups')->insert([
            'nama_group' => 'Administrator',
            'deskripsi' => 'Full access to all features',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('groups')->insert([
            'nama_group' => 'Operator',
            'deskripsi' => 'Can manage burial and family data',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('groups')->insert([
            'nama_group' => 'Kasir',
            'deskripsi' => 'Can manage billing and payments',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $this->db->table('groups')->insert([
            'nama_group' => 'Viewer',
            'deskripsi' => 'Read-only access',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Create admin user
        $this->db->table('users')->insert([
            'username' => 'admin',
            'email' => 'admin@simakam.local',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'nama_lengkap' => 'Administrator',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Assign admin to Administrator group
        $this->db->table('user_groups')->insert([
            'user_id' => 1,
            'group_id' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Create menus
        $menus = [
            ['nama_menu' => 'Dashboard', 'url' => 'dashboard', 'icon' => 'bi-speedometer2', 'parent_id' => null, 'urutan' => 1],
            ['nama_menu' => 'Master Data', 'url' => '#', 'icon' => 'bi-database', 'parent_id' => null, 'urutan' => 2],
            ['nama_menu' => 'Lokasi Makam', 'url' => 'lokasi-makam', 'icon' => 'bi-geo-alt', 'parent_id' => 2, 'urutan' => 1],
            ['nama_menu' => 'Data Jenazah', 'url' => 'jenazah', 'icon' => 'bi-person-badge', 'parent_id' => 2, 'urutan' => 2],
            ['nama_menu' => 'Data Keluarga', 'url' => 'keluarga', 'icon' => 'bi-people', 'parent_id' => 2, 'urutan' => 3],
            ['nama_menu' => 'Pemakaman', 'url' => '#', 'icon' => 'bi-tree', 'parent_id' => null, 'urutan' => 3],
            ['nama_menu' => 'Data Pemakaman', 'url' => 'pemakaman', 'icon' => 'bi-list-check', 'parent_id' => 6, 'urutan' => 1],
            ['nama_menu' => 'Perawatan Makam', 'url' => 'perawatan', 'icon' => 'bi-brush', 'parent_id' => 6, 'urutan' => 2],
            ['nama_menu' => 'Keuangan', 'url' => '#', 'icon' => 'bi-wallet2', 'parent_id' => null, 'urutan' => 4],
            ['nama_menu' => 'Tagihan Keluarga', 'url' => 'tagihan', 'icon' => 'bi-receipt', 'parent_id' => 9, 'urutan' => 1],
            ['nama_menu' => 'Pembayaran', 'url' => 'pembayaran', 'icon' => 'bi-cash-stack', 'parent_id' => 9, 'urutan' => 2],
            ['nama_menu' => 'Pengeluaran', 'url' => 'pengeluaran', 'icon' => 'bi-cart-dash', 'parent_id' => 9, 'urutan' => 3],
            ['nama_menu' => 'Pembelian Alat', 'url' => 'pembelian', 'icon' => 'bi-tools', 'parent_id' => 9, 'urutan' => 4],
            ['nama_menu' => 'Kepegawaian', 'url' => '#', 'icon' => 'bi-person-workspace', 'parent_id' => null, 'urutan' => 5],
            ['nama_menu' => 'Data Karyawan', 'url' => 'karyawan', 'icon' => 'bi-person-vcard', 'parent_id' => 14, 'urutan' => 1],
            ['nama_menu' => 'Tunjangan', 'url' => 'tunjangan', 'icon' => 'bi-gift', 'parent_id' => 14, 'urutan' => 2],
            ['nama_menu' => 'Penggajian', 'url' => 'gaji', 'icon' => 'bi-credit-card', 'parent_id' => 14, 'urutan' => 3],
            ['nama_menu' => 'Laporan', 'url' => '#', 'icon' => 'bi-file-earmark-bar-graph', 'parent_id' => null, 'urutan' => 6],
            ['nama_menu' => 'Laporan Pemakaman', 'url' => 'reports/pemakaman', 'icon' => 'bi-file-text', 'parent_id' => 18, 'urutan' => 1],
            ['nama_menu' => 'Laporan Perawatan', 'url' => 'reports/perawatan', 'icon' => 'bi-file-text', 'parent_id' => 18, 'urutan' => 2],
            ['nama_menu' => 'Laporan Keuangan', 'url' => 'reports/keuangan', 'icon' => 'bi-file-text', 'parent_id' => 18, 'urutan' => 3],
            ['nama_menu' => 'Pengaturan', 'url' => '#', 'icon' => 'bi-gear', 'parent_id' => null, 'urutan' => 7],
            ['nama_menu' => 'Users', 'url' => 'users', 'icon' => 'bi-people-fill', 'parent_id' => 22, 'urutan' => 1],
            ['nama_menu' => 'Groups', 'url' => 'groups', 'icon' => 'bi-diagram-3', 'parent_id' => 22, 'urutan' => 2],
            ['nama_menu' => 'Menu & Permissions', 'url' => 'menus', 'icon' => 'bi-list-ul', 'parent_id' => 22, 'urutan' => 3],
            ['nama_menu' => 'Company Profile', 'url' => '#', 'icon' => 'bi-building', 'parent_id' => 22, 'urutan' => 4],
            ['nama_menu' => 'Hero Section', 'url' => 'compro/hero', 'icon' => 'bi-image', 'parent_id' => 26, 'urutan' => 1],
            ['nama_menu' => 'About', 'url' => 'compro/about', 'icon' => 'bi-info-circle', 'parent_id' => 26, 'urutan' => 2],
            ['nama_menu' => 'Services', 'url' => 'compro/services', 'icon' => 'bi-box', 'parent_id' => 26, 'urutan' => 3],
            ['nama_menu' => 'Gallery', 'url' => 'compro/gallery', 'icon' => 'bi-images', 'parent_id' => 26, 'urutan' => 4],
            ['nama_menu' => 'Testimonials', 'url' => 'compro/testimonials', 'icon' => 'bi-chat-quote', 'parent_id' => 26, 'urutan' => 5],
            ['nama_menu' => 'Contact', 'url' => 'compro/contact', 'icon' => 'bi-telephone', 'parent_id' => 26, 'urutan' => 6],
        ];

        foreach ($menus as $menu) {
            $this->db->table('menus')->insert([
                'nama_menu' => $menu['nama_menu'],
                'url' => $menu['url'],
                'icon' => $menu['icon'],
                'parent_id' => $menu['parent_id'],
                'urutan' => $menu['urutan'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Give admin full permissions on all menus
        for ($i = 1; $i <= count($menus); $i++) {
            $this->db->table('menu_permissions')->insert([
                'group_id' => 1,
                'menu_id' => $i,
                'can_view' => 1,
                'can_create' => 1,
                'can_update' => 1,
                'can_delete' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Sample lokasi makam
        $lokasiList = [
            ['kode_blok' => 'A1', 'nama_blok' => 'Blok A1 - Umum', 'kapasitas' => 100, 'harga_sewa' => 2500000],
            ['kode_blok' => 'A2', 'nama_blok' => 'Blok A2 - Umum', 'kapasitas' => 100, 'harga_sewa' => 2500000],
            ['kode_blok' => 'B1', 'nama_blok' => 'Blok B1 - VIP', 'kapasitas' => 50, 'harga_sewa' => 5000000],
            ['kode_blok' => 'B2', 'nama_blok' => 'Blok B2 - VIP', 'kapasitas' => 50, 'harga_sewa' => 5000000],
            ['kode_blok' => 'C1', 'nama_blok' => 'Blok C1 - VVIP', 'kapasitas' => 25, 'harga_sewa' => 10000000],
        ];

        foreach ($lokasiList as $lokasi) {
            $this->db->table('lokasi_makam')->insert([
                'kode_blok' => $lokasi['kode_blok'],
                'nama_blok' => $lokasi['nama_blok'],
                'kapasitas' => $lokasi['kapasitas'],
                'terisi' => 0,
                'harga_sewa' => $lokasi['harga_sewa'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Sample tunjangan
        $tunjanganList = [
            ['nama_tunjangan' => 'Tunjangan Makan', 'jenis' => 'tetap', 'nominal' => 500000],
            ['nama_tunjangan' => 'Tunjangan Transport', 'jenis' => 'tetap', 'nominal' => 300000],
            ['nama_tunjangan' => 'Tunjangan Kesehatan', 'jenis' => 'tetap', 'nominal' => 400000],
            ['nama_tunjangan' => 'Tunjangan Hari Raya', 'jenis' => 'tidak_tetap', 'nominal' => 1000000],
            ['nama_tunjangan' => 'Bonus Kinerja', 'jenis' => 'tidak_tetap', 'nominal' => 500000],
        ];

        foreach ($tunjanganList as $tunjangan) {
            $this->db->table('tunjangan')->insert([
                'nama_tunjangan' => $tunjangan['nama_tunjangan'],
                'jenis' => $tunjangan['jenis'],
                'nominal' => $tunjangan['nominal'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // System settings
        $settings = [
            ['key' => 'nama_tpu', 'value' => 'TPU Serenity Memorial Park', 'type' => 'text', 'group' => 'general'],
            ['key' => 'alamat_tpu', 'value' => 'Jl. Ketenangan No. 123, Jakarta Selatan', 'type' => 'textarea', 'group' => 'general'],
            ['key' => 'telepon_tpu', 'value' => '021-12345678', 'type' => 'text', 'group' => 'general'],
            ['key' => 'email_tpu', 'value' => 'info@serenity-memorial.id', 'type' => 'text', 'group' => 'general'],
            ['key' => 'logo', 'value' => '', 'type' => 'image', 'group' => 'general'],
            ['key' => 'primary_color', 'value' => '#1a365d', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'secondary_color', 'value' => '#2d3748', 'type' => 'text', 'group' => 'theme'],
            ['key' => 'denda_per_hari', 'value' => '5000', 'type' => 'number', 'group' => 'billing'],
            ['key' => 'masa_berlaku_default', 'value' => '3', 'type' => 'number', 'group' => 'billing'],
        ];

        foreach ($settings as $setting) {
            $this->db->table('settings')->insert([
                'key' => $setting['key'],
                'value' => $setting['value'],
                'type' => $setting['type'],
                'group' => $setting['group'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Compro Hero
        $this->db->table('compro_hero')->insert([
            'judul' => 'TPU Serenity Memorial Park',
            'subjudul' => 'Tempat Peristirahatan Terakhir yang Damai dan Terhormat. Kami menyediakan layanan pemakaman profesional dengan penuh kehormatan.',
            'cta_text' => 'Hubungi Kami',
            'cta_url' => '#contact',
            'is_active' => 1,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Compro About
        $this->db->table('compro_about')->insert([
            'judul' => 'Tentang Kami',
            'deskripsi' => 'TPU Serenity Memorial Park adalah tempat pemakaman umum yang dikelola secara profesional dengan standar pelayanan terbaik. Kami berkomitmen memberikan tempat peristirahatan terakhir yang layak, damai, dan terhormat bagi orang-orang terkasih Anda.',
            'visi' => 'Menjadi tempat pemakaman terbaik yang memberikan pelayanan profesional dan bermartabat.',
            'misi' => '1. Menyediakan layanan pemakaman yang profesional\n2. Memelihara area pemakaman dengan baik\n3. Memberikan kemudahan administrasi bagi keluarga\n4. Menjaga ketenangan dan keasrian lingkungan',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Compro Services
        $services = [
            ['nama_layanan' => 'Pemakaman Umum', 'deskripsi' => 'Layanan pemakaman standar dengan lokasi yang nyaman dan terawat.', 'icon' => 'bi-tree', 'harga' => 2500000, 'urutan' => 1],
            ['nama_layanan' => 'Pemakaman VIP', 'deskripsi' => 'Layanan pemakaman premium dengan lokasi strategis dan fasilitas lebih baik.', 'icon' => 'bi-star', 'harga' => 5000000, 'urutan' => 2],
            ['nama_layanan' => 'Pemakaman VVIP', 'deskripsi' => 'Layanan pemakaman eksklusif dengan area privat dan perawatan intensif.', 'icon' => 'bi-gem', 'harga' => 10000000, 'urutan' => 3],
            ['nama_layanan' => 'Perawatan Berkala', 'deskripsi' => 'Layanan perawatan makam secara berkala meliputi pembersihan dan penanaman bunga.', 'icon' => 'bi-brush', 'harga' => 500000, 'urutan' => 4],
            ['nama_layanan' => 'Renovasi Makam', 'deskripsi' => 'Layanan renovasi dan perbaikan nisan atau area makam.', 'icon' => 'bi-tools', 'harga' => 1500000, 'urutan' => 5],
        ];

        foreach ($services as $service) {
            $this->db->table('compro_services')->insert([
                'nama_layanan' => $service['nama_layanan'],
                'deskripsi' => $service['deskripsi'],
                'icon' => $service['icon'],
                'harga' => $service['harga'],
                'urutan' => $service['urutan'],
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Compro Contact
        $this->db->table('compro_contact')->insert([
            'alamat' => 'Jl. Ketenangan No. 123, Kelurahan Damai, Kecamatan Tenteram, Jakarta Selatan 12345',
            'telepon' => '021-12345678',
            'whatsapp' => '081234567890',
            'email' => 'info@serenity-memorial.id',
            'jam_operasional' => 'Senin - Minggu: 07:00 - 17:00 WIB',
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Sample Karyawan
        $karyawanList = [
            ['nip' => 'KRY001', 'nama_lengkap' => 'Ahmad Sudrajat', 'jabatan' => 'Kepala TPU', 'gaji_pokok' => 5000000],
            ['nip' => 'KRY002', 'nama_lengkap' => 'Budi Santoso', 'jabatan' => 'Staff Administrasi', 'gaji_pokok' => 3500000],
            ['nip' => 'KRY003', 'nama_lengkap' => 'Citra Dewi', 'jabatan' => 'Kasir', 'gaji_pokok' => 3500000],
            ['nip' => 'KRY004', 'nama_lengkap' => 'Dedi Kurniawan', 'jabatan' => 'Petugas Lapangan', 'gaji_pokok' => 3000000],
            ['nip' => 'KRY005', 'nama_lengkap' => 'Eko Prasetyo', 'jabatan' => 'Petugas Lapangan', 'gaji_pokok' => 3000000],
        ];

        foreach ($karyawanList as $karyawan) {
            $this->db->table('karyawan')->insert([
                'nip' => $karyawan['nip'],
                'nama_lengkap' => $karyawan['nama_lengkap'],
                'jabatan' => $karyawan['jabatan'],
                'tanggal_masuk' => '2024-01-01',
                'gaji_pokok' => $karyawan['gaji_pokok'],
                'status' => 'aktif',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
