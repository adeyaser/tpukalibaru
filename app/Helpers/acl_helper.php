<?php

/**
 * ACL Helper Functions
 * 
 * Load this helper with:
 * helper('acl');
 */

if (!function_exists('has_permission')) {
    /**
     * Check if current user has permission on a menu
     * 
     * @param string $menuUrl Menu URL/identifier
     * @param string $action Action: view, create, update, delete
     * @return bool
     */
    function has_permission(string $menuUrl, string $action = 'view'): bool
    {
        $userId = session()->get('userId');
        if (!$userId) {
            return false;
        }

        $menuModel = new \App\Models\MenuModel();
        return $menuModel->hasPermission($userId, $menuUrl, $action);
    }
}

if (!function_exists('can_access')) {
    /**
     * Check if current user can access a menu (view permission)
     * 
     * @param string $menuUrl Menu URL/identifier
     * @return bool
     */
    function can_access(string $menuUrl): bool
    {
        return has_permission($menuUrl, 'view');
    }
}

if (!function_exists('can_create')) {
    /**
     * Check if current user can create in a module
     */
    function can_create(string $menuUrl): bool
    {
        return has_permission($menuUrl, 'create');
    }
}

if (!function_exists('can_update')) {
    /**
     * Check if current user can update in a module
     */
    function can_update(string $menuUrl): bool
    {
        return has_permission($menuUrl, 'update');
    }
}

if (!function_exists('can_delete')) {
    /**
     * Check if current user can delete in a module
     */
    function can_delete(string $menuUrl): bool
    {
        return has_permission($menuUrl, 'delete');
    }
}

if (!function_exists('get_user_menus')) {
    /**
     * Get menus accessible by current user
     * Returns hierarchical array of menus
     * 
     * @return array
     */
    function get_user_menus(): array
    {
        $userId = session()->get('userId');
        if (!$userId) {
            return [];
        }

        $menuModel = new \App\Models\MenuModel();
        return $menuModel->getUserMenus($userId);
    }
}

if (!function_exists('is_admin')) {
    /**
     * Check if current user is in Administrator group
     */
    function is_admin(): bool
    {
        $groups = session()->get('groups');
        if (!$groups) {
            return false;
        }

        foreach ($groups as $group) {
            if (strtolower($group['nama_group']) === 'administrator') {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('current_user')) {
    /**
     * Get current logged in user data from session
     */
    function current_user(): ?array
    {
        if (!session()->get('isLoggedIn')) {
            return null;
        }

        return [
            'id' => session()->get('userId'),
            'username' => session()->get('username'),
            'email' => session()->get('email'),
            'nama_lengkap' => session()->get('namaLengkap'),
            'foto' => session()->get('foto'),
            'groups' => session()->get('groups'),
        ];
    }
}

if (!function_exists('format_rupiah')) {
    /**
     * Format number as Indonesian Rupiah
     */
    function format_rupiah($number, bool $withPrefix = true): string
    {
        $formatted = number_format($number, 0, ',', '.');
        return $withPrefix ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('format_date')) {
    /**
     * Format date to Indonesian format
     */
    function format_date($date, string $format = 'd M Y'): string
    {
        if (empty($date)) return '-';
        return date($format, strtotime($date));
    }
}

if (!function_exists('terbilang')) {
    function terbilang($x) {
        $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        if ($x < 12)
            return " " . $angka[$x];
        elseif ($x < 20)
            return terbilang($x - 10) . " belas";
        elseif ($x < 100)
            return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        elseif ($x < 200)
            return " seratus" . terbilang($x - 100);
        elseif ($x < 1000)
            return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        elseif ($x < 2000)
            return " seribu" . terbilang($x - 1000);
        elseif ($x < 1000000)
            return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        elseif ($x < 1000000000)
            return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    }
}

if (!function_exists('get_setting')) {
    /**
     * Get system setting by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting(string $key, $default = null)
    {
        $settingModel = new \App\Models\SettingModel();
        return $settingModel->getValue($key) ?? $default;
    }
}
