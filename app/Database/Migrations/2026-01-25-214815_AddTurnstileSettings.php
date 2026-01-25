<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTurnstileSettings extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('settings');

        $data = [
            [
                'key'   => 'turnstile_site_key',
                'value' => '1x00000000000000000000AA', // Always Passes - Test Key
                'type'  => 'text',
                'group' => 'general'
            ],
            [
                'key'   => 'turnstile_secret_key',
                'value' => '1x0000000000000000000000000000000AA', // Always Passes - Test Key
                'type'  => 'text',
                'group' => 'general'
            ],
        ];

        foreach ($data as $d) {
            // Check if exists
            $exists = $builder->where('key', $d['key'])->countAllResults();
            if (!$exists) {
                $builder->insert($d);
            }
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $db->table('settings')->whereIn('key', ['turnstile_site_key', 'turnstile_secret_key'])->delete();
    }
}
