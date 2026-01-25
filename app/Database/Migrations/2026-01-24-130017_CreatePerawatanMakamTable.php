<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePerawatanMakamTable extends Migration
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
            'pemakaman_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tanggal_perawatan' => [
                'type' => 'DATE',
            ],
            'jenis_perawatan' => [
                'type' => 'ENUM',
                'constraint' => ['pembersihan', 'perbaikan', 'pengecatan', 'penanaman', 'lainnya'],
                'default' => 'pembersihan',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'biaya' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'default' => 0,
            ],
            'foto_sebelum' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'foto_sesudah' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'karyawan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['dijadwalkan', 'selesai', 'dibatalkan'],
                'default' => 'selesai',
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
        $this->forge->addForeignKey('pemakaman_id', 'pemakaman', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('perawatan_makam');
    }

    public function down()
    {
        $this->forge->dropTable('perawatan_makam');
    }
}
