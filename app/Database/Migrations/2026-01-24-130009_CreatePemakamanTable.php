<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePemakamanTable extends Migration
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
            'no_makam' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'unique' => true,
            ],
            'jenazah_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'lokasi_makam_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tanggal_pemakaman' => [
                'type' => 'DATETIME',
            ],
            'baris' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'nomor' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'biaya_pemakaman' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'biaya_perawatan_tahunan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'masa_berlaku' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['aktif', 'kadaluarsa', 'dipindahkan'],
                'default' => 'aktif',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('jenazah_id');
        $this->forge->addKey('lokasi_makam_id');
        $this->forge->addForeignKey('jenazah_id', 'jenazah', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('lokasi_makam_id', 'lokasi_makam', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pemakaman');
    }

    public function down()
    {
        $this->forge->dropTable('pemakaman');
    }
}
