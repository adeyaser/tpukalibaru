<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTagihanForMultiItems extends Migration
{
    public function up()
    {
        // 1. Add 'gali_makam' to jenis_tagihan enum in tagihan_keluarga
        // Since sqlite doesn't support MODIFY COLUMN easily, and we are using MySQL (as seen in .env), we use raw query.
        $this->db->query("ALTER TABLE tagihan_keluarga MODIFY COLUMN jenis_tagihan ENUM('pemakaman', 'perawatan', 'perpanjangan', 'lainnya', 'gali_makam') NOT NULL DEFAULT 'perawatan'");

        // 2. Create tagihan_keluarga_items table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tagihan_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_item' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'nominal' => [
                'type'           => 'DECIMAL',
                'constraint'     => '15,2',
                'default'        => 0,
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('tagihan_id');
        $this->forge->addForeignKey('tagihan_id', 'tagihan_keluarga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tagihan_keluarga_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('tagihan_keluarga_items');
        $this->db->query("ALTER TABLE tagihan_keluarga MODIFY COLUMN jenis_tagihan ENUM('pemakaman', 'perawatan', 'perpanjangan', 'lainnya') NOT NULL DEFAULT 'perawatan'");
    }
}
