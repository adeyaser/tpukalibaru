<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiMakamTable extends Migration
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
            'kode_blok' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'nama_blok' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'kapasitas' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
            ],
            'terisi' => [
                'type' => 'INT',
                'constraint' => 5,
                'default' => 0,
            ],
            'harga_sewa' => [
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
        $this->forge->createTable('lokasi_makam');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_makam');
    }
}
