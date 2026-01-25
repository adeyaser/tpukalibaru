<?php

use App\Models\SettingModel;

if (!function_exists('get_setting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function get_setting($key, $default = null)
    {
        $model = new SettingModel();
        $value = $model->getValue($key);
        return $value !== null ? $value : $default;
    }
}
