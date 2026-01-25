<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RepairMenuSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();
        
        // Helper to get or create menu
        $getOrCreate = function($title, $url, $icon, $parentId = null, $order = 0) use ($db) {
            $menu = $db->table('menus')->where('nama_menu', $title)->get()->getRowArray();
            if (!$menu) {
                $db->table('menus')->insert([
                    'nama_menu' => $title,
                    'url' => $url,
                    'icon' => $icon,
                    'parent_id' => $parentId,
                    'urutan' => $order,
                    'is_active' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
                $id = $db->insertID();
                echo "Created menu: $title (ID: $id)\n";
                
                // Add permission for Admin (Group 1)
                $db->table('menu_permissions')->insert([
                    'group_id' => 1,
                    'menu_id' => $id,
                    'can_view' => 1,
                    'can_create' => 1,
                    'can_update' => 1,
                    'can_delete' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);
                
                return $id;
            } else {
                // Update parent if needed (repair hierarchy)
                if ($menu['parent_id'] != $parentId) {
                    $db->table('menus')->where('id', $menu['id'])->update(['parent_id' => $parentId]);
                    echo "Updated parent for: $title\n";
                }
                // Update URL if needed (fix URLs)
                if ($menu['url'] != $url) {
                    $db->table('menus')->where('id', $menu['id'])->update(['url' => $url]);
                    echo "Updated URL for: $title\n";
                }
                return $menu['id'];
            }
        };

        // 1. Root: Pengaturan
        $pengaturanId = $getOrCreate('Pengaturan', '#', 'bi-gear', null, 99);

        // 2. Child of Pengaturan: Pengaturan Umum (Nama Sistem, Logo, dll)
        $getOrCreate('Pengaturan Umum', 'settings', 'bi-gear-fill', $pengaturanId, 1);

        // 3. Child of Pengaturan: Company Profile (Grouping)
        $comproId = $getOrCreate('Company Profile', '#', 'bi-building', $pengaturanId, 5);

        // 4. Children of Company Profile
        $comproMenus = [
            ['Hero Section', 'compro-settings/hero', 'bi-image', 1],
            ['About', 'compro-settings/about', 'bi-info-circle', 2],
            ['Services', 'compro-settings/services', 'bi-box', 3],
            ['Gallery', 'compro-settings/gallery', 'bi-images', 4],
            ['Testimonials', 'compro-settings/testimonials', 'bi-chat-quote', 5],
            ['Contact', 'compro-settings/contact', 'bi-telephone', 6],
        ];

        foreach ($comproMenus as $item) {
            $getOrCreate($item[0], $item[1], $item[2], $comproId, $item[3]);
        }
        
        // 5. Ensure Users, Groups, Menu & Permissions are under Pengaturan too if they exist
        // (Just fixing parent_id if they exist)
        $sysMenus = ['Users', 'Groups', 'Menu & Permissions'];
        foreach ($sysMenus as $mName) {
            $m = $db->table('menus')->where('nama_menu', $mName)->get()->getRowArray();
            if ($m && $m['parent_id'] != $pengaturanId) {
                // Assuming they should be under Pengaturan
                $db->table('menus')->where('id', $m['id'])->update(['parent_id' => $pengaturanId]);
                echo "Moved $mName to Pengaturan\n";
            }
        }
    }
}
