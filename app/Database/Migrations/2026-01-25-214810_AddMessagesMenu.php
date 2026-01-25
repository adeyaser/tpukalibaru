<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMessagesMenu extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // Get parent ID for "Company Profile"
        $parent = $db->table('menus')->where('nama_menu', 'Company Profile')->get()->getRowArray();
        $parentId = $parent ? $parent['id'] : null;

        // Insert new menu
        $db->table('menus')->insert([
            'nama_menu' => 'Pesan Masuk',
            'url'       => 'compro-settings/messages',
            'icon'      => 'bi-chat-left-text',
            'parent_id' => $parentId,
            'urutan'    => 7, // After Contact
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $menuId = $db->insertID();

        // Give admin (group_id 1) permission
        $db->table('menu_permissions')->insert([
            'group_id'   => 1,
            'menu_id'    => $menuId,
            'can_view'   => 1,
            'can_create' => 0,
            'can_update' => 0,
            'can_delete' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $db->table('menus')->where('nama_menu', 'Pesan Masuk')->delete();
    }
}
