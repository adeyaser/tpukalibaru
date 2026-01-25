<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActiveToTunjangan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tunjangan', [
            'is_active' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
                'after' => 'deskripsi'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tunjangan', 'is_active');
    }
}
