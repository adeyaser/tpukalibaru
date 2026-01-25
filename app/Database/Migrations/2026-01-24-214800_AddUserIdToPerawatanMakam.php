<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToPerawatanMakam extends Migration
{
    public function up()
    {
        $fields = [
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'karyawan_id',
            ],
        ];
        $this->forge->addColumn('perawatan_makam', $fields);
        
        // Optional: Add Foreign Key if desired, but for now just column is enough to fix the crash.
        // Adding FK is safer for integrity.
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->processIndexes('perawatan_makam');
    }

    public function down()
    {
        $this->forge->dropForeignKey('perawatan_makam', 'perawatan_makam_user_id_foreign');
        $this->forge->dropColumn('perawatan_makam', 'user_id');
    }
}
