<?php
namespace App\Controllers;
use App\Controllers\BaseController;

class DebugMenu extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        
        echo "<h1>Debug Menu Structure</h1>";
        
        $menus = $db->table('menus')->orderBy('urutan')->get()->getResultArray();
        echo "<pre>";
        foreach($menus as $m) {
            echo "ID: {$m['id']} | Name: {$m['nama_menu']} | Parent: {$m['parent_id']} | URL: {$m['url']}\n";
        }
        echo "</pre>";

        echo "<h2>Permissions for Group 1 (Admin)</h2>";
        $perms = $db->table('menu_permissions')->where('group_id', 1)->get()->getResultArray();
        $permMenuIds = array_column($perms, 'menu_id');
        echo "Allowed Menu IDs: " . implode(', ', $permMenuIds);
    }
}
