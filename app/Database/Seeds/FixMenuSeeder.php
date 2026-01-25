<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FixMenuSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // 1. Get Parent ID for 'Pengaturan'
        $pengaturan = $db->table('menus')->where('nama_menu', 'Pengaturan')->get()->getRowArray();
        if (!$pengaturan) {
            // Should not happen if MainSeeder ran, but safety check
            return; 
        }
        $pengaturanId = $pengaturan['id'];

        // 2. Add 'Pengaturan Umum' (Settings) if not exists
        $settingsMenu = $db->table('menus')->where('url', 'settings')->get()->getRowArray();
        if (!$settingsMenu) {
            $db->table('menus')->insert([
                'nama_menu' => 'Pengaturan Umum',
                'url' => 'settings',
                'icon' => 'bi-gear', // Using distinct icon or similar
                'parent_id' => $pengaturanId,
                'urutan' => 0, // Put at top
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            $settingsId = $db->insertID();
            
            // Add permission for Admin
            $db->table('menu_permissions')->insert([
                'group_id' => 1, // Admin
                'menu_id' => $settingsId,
                'can_view' => 1,
                'can_create' => 1,
                'can_update' => 1,
                'can_delete' => 1,
            ]);
        }

        // 3. Fix Company Profile Submenus URLs
        // Get Company Profile menu ID
        $compro = $db->table('menus')->where('nama_menu', 'Company Profile')->get()->getRowArray();
        if ($compro) {
            $comproId = $compro['id'];
            
            // Update children
            $updates = [
                'compro/hero' => 'compro-settings/hero',
                'compro/about' => 'compro-settings/about',
                'compro/services' => 'compro-settings/services',
                'compro/gallery' => 'compro-settings/gallery',
                'compro/testimonials' => 'compro-settings/testimonials',
                'compro/contact' => 'compro-settings/contact',
            ];

            foreach ($updates as $old => $new) {
                $db->table('menus')
                    ->where('parent_id', $comproId)
                    ->where('url', $old)
                    ->update(['url' => $new]);
            }
        }
    }
}
