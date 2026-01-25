<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToPengeluaran extends Migration
{
    public function up()
    {
        if (!$this->db->fieldExists('status', 'pengeluaran')) {
            $this->forge->addColumn('pengeluaran', [
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['dibayar', 'pending'],
                    'default'    => 'dibayar',
                    'after'      => 'bukti'
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('pengeluaran', 'status');
    }
}
