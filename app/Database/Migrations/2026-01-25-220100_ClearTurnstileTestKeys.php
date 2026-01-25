<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ClearTurnstileTestKeys extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        $db->table('settings')
           ->whereIn('key', ['turnstile_site_key', 'turnstile_secret_key'])
           ->update(['value' => '']);
    }

    public function down()
    {
        // No need to restore test keys on rollback
    }
}
