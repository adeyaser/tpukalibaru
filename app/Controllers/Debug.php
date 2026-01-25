<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class Debug extends BaseController
{
    public function menu()
    {
        $db = \Config\Database::connect();
        $menuModel = new MenuModel();
        
        echo "<h1>Debug Menu</h1>";
        
        $userId = session()->get('userId');
        echo "<p>User ID in Session: " . ($userId ?? 'NULL') . "</p>";
        
        if ($userId) {
            $userGroups = $db->table('user_groups')->where('user_id', $userId)->get()->getResultArray();
            echo "<h3>User Groups:</h3><pre>";
            print_r($userGroups);
            echo "</pre>";
            
            $menus = $menuModel->getUserMenus($userId);
            echo "<h3>Generated Menus:</h3><pre>";
            print_r($menus);
            echo "</pre>";
        } else {
            // Check Admin User (ID 1)
            echo "<h3>Checking Admin User (ID 1) directly:</h3>";
            $menus = $menuModel->getUserMenus(1);
            echo "<pre>";
            print_r($menus);
            echo "</pre>";
        }
        
        echo "<h3>Raw Menus Table (CMS items):</h3><pre>";
        $cmsMenus = $db->table('menus')->whereIn('url', ['settings', 'compro-settings'])->get()->getResultArray();
        print_r($cmsMenus);
        echo "</pre>";

        echo "<h3>Raw Permissions Table (for CMS items):</h3><pre>";
        foreach($cmsMenus as $m) {
             $perms = $db->table('menu_permissions')->where('menu_id', $m['id'])->get()->getResultArray();
             echo "Menu: {$m['title']} ({$m['id']})\n";
             print_r($perms);
        }
        echo "</pre>";
    }
}
