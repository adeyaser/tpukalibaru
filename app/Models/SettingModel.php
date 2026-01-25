<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['key', 'value', 'type', 'group'];

    // Method helper untuk ambil value berdasarkan key
    public function getValue($key)
    {
        $setting = $this->where('key', $key)->first();
        return $setting ? $setting['value'] : null;
    }

    // Method helper untuk update/create setting
    public function saveSetting($key, $value, $group = 'general', $type = 'string')
    {
        $existing = $this->where('key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['value' => $value]);
        }
        return $this->insert([
            'key' => $key,
            'value' => $value,
            'group' => $group,
            'type' => $type
        ]);
    }
}
