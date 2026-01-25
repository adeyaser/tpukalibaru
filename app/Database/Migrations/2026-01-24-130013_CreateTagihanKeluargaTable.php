<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagihanKeluargaTable extends Migration
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
            'no_tagihan' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'unique' => true,
            ],
            'pemakaman_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'keluarga_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'jenis_tagihan' => [
                'type' => 'ENUM',
                'constraint' => ['pemakaman', 'perawatan', 'perpanjangan', 'lainnya'],
                'default' => 'perawatan',
            ],
            'periode_mulai' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'periode_akhir' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'nominal' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'denda' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'terbayar' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'sisa' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'jatuh_tempo' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum_bayar', 'cicilan', 'lunas'],
                'default' => 'belum_bayar',
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
        $this->forge->addKey('pemakaman_id');
        $this->forge->addKey('keluarga_id');
        $this->forge->addForeignKey('pemakaman_id', 'pemakaman', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('keluarga_id', 'keluarga_jenazah', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('tagihan_keluarga');
    }

    public function down()
    {
        $this->forge->dropTable('tagihan_keluarga');
    }
}
