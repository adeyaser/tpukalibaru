<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'nama_menu', 'url', 'icon', 'parent_id', 'urutan', 'is_active'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Get all menus in hierarchical structure
     */
    public function getMenuTree()
    {
        $menus = $this->where('is_active', 1)
                      ->orderBy('urutan', 'ASC')
                      ->findAll();

        return $this->buildTree($menus);
    }

    /**
     * Build hierarchical tree from flat array
     */
    protected function buildTree(array $menus, $parentId = null): array
    {
        $tree = [];
        foreach ($menus as $menu) {
            if ($menu['parent_id'] == $parentId) {
                $children = $this->buildTree($menus, $menu['id']);
                if ($children) {
                    $menu['children'] = $children;
                }
                $tree[] = $menu;
            }
        }
        return $tree;
    }

    /**
     * Get menus accessible by a user based on their groups
     */
    public function getUserMenus(int $userId)
    {
        $db = \Config\Database::connect();
        
        // Get user's group IDs
        $groupIds = $db->table('user_groups')
            ->select('group_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        if (empty($groupIds)) {
            return [];
        }

        $groupIds = array_column($groupIds, 'group_id');
        
        // SUPERADMIN BYPASS (Group 1)
        if (in_array(1, $groupIds)) {
             $menus = $this->where('is_active', 1)
                          ->orderBy('urutan', 'ASC')
                          ->findAll();
             return $this->buildTree($menus);
        }

        // Get menus that user has at least view permission
        $menuIds = $db->table('menu_permissions')
            ->select('menu_id')
            ->whereIn('group_id', $groupIds)
            ->where('can_view', 1)
            ->get()
            ->getResultArray();

        if (empty($menuIds)) {
            return [];
        }

        $menuIds = array_column($menuIds, 'menu_id');

        // Get parent menus too
        $menus = $this->where('is_active', 1)
                      ->whereIn('id', $menuIds)
                      ->findAll();

        // Add parent menus
        // Recursively get parent menus
        $allMenuIds = array_column($menus, 'id');
        $parentIds = array_filter(array_unique(array_column($menus, 'parent_id')));
        
        while (!empty($parentIds)) {
            // Find parents that are not yet in our list
            $missingParentIds = array_diff($parentIds, $allMenuIds);
            
            if (empty($missingParentIds)) {
                break;
            }
            
            $parents = $this->where('is_active', 1)
                           ->whereIn('id', $missingParentIds)
                           ->findAll();
            
            if (empty($parents)) {
                break;
            }
            
            $menus = array_merge($menus, $parents);
            
            // Updates for next iteration
            foreach ($parents as $p) {
                $allMenuIds[] = $p['id'];
            }
            $parentIds = array_filter(array_unique(array_column($parents, 'parent_id')));
        }

        // Unique and sort
        $menus = array_unique($menus, SORT_REGULAR);
        usort($menus, fn($a, $b) => $a['urutan'] <=> $b['urutan']);

        return $this->buildTree($menus);
    }

    /**
     * Check if user has permission on a menu
     */
    public function hasPermission(int $userId, string $menuUrl, string $action = 'view'): bool
    {
        $db = \Config\Database::connect();

        // Get menu by URL
        $menu = $this->where('url', $menuUrl)->first();
        if (!$menu) {
            return false;
        }

        // Get user's groups
        $groupIds = $db->table('user_groups')
            ->select('group_id')
            ->where('user_id', $userId)
            ->get()
            ->getResultArray();

        if (empty($groupIds)) {
            return false;
        }

        $groupIds = array_column($groupIds, 'group_id');

        // Check permission
        // SUPERADMIN BYPASS (Group 1)
        if (in_array(1, $groupIds)) {
            return true;
        }

        $actionField = 'can_' . $action;
        $permission = $db->table('menu_permissions')
            ->whereIn('group_id', $groupIds)
            ->where('menu_id', $menu['id'])
            ->where($actionField, 1)
            ->get()
            ->getRow();

        return $permission !== null;
    }
}
