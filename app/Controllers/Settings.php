<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class Settings extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Pengaturan Umum',
            'settings' => $this->getSettings()
        ];
        return view('settings/index', $data);
    }

    public function update()
    {
        // Handle Logo Upload
        $logo = $this->request->getFile('site_logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $newName = $logo->getRandomName();
            $logo->move('uploads/settings', $newName);
            $this->settingModel->saveSetting('site_logo', $newName, 'general', 'image');
        }

        // Save other settings
        $fields = [
            'site_title', 'nama_tpu', 'site_description', 'site_address', 'site_email', 'site_phone', 
            'theme_color'
        ];
        foreach ($fields as $field) {
            if ($this->request->getPost($field)) {
                $this->settingModel->saveSetting($field, $this->request->getPost($field));
            }
        }

        return redirect()->to('/settings')->with('success', 'Pengaturan berhasil disimpan');
    }

    private function getSettings()
    {
        $settings = $this->settingModel->findAll();
        $result = [];
        foreach ($settings as $s) {
            $result[$s['key']] = $s['value'];
        }
        return $result;
    }
}
