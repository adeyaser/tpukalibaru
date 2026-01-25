<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTunjanganTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_tunjangan' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'jenis' => [
                'type' => 'ENUM',
                'constraint' => ['tetap', 'tidak_tetap'],
                'default' => 'tetap',
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tunjangan');
    }

    public function down()
    {
        $this->forge->dropTable('tunjangan');
    }
}
