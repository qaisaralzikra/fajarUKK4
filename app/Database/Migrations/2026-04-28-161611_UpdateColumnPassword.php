<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateColumnPassword extends Migration
{
    public function up()
    {
        $fields = [
            'password' => [
                'name'       => 'password', // Tetap gunakan nama yang sama
                'type'       => 'VARCHAR',
                'constraint' => 255,        // Ubah dari 20 ke 255
            ],
        ];

        // Gunakan modifyColumn untuk mengubah struktur yang sudah ada
        $this->forge->modifyColumn('users', $fields);
    }

    public function down()
    {
        // Jika ingin dikembalikan ke 20 (tidak disarankan jika sudah ada data hash)
        $fields = [
            'password' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
        ];
        $this->forge->modifyColumn('users', $fields);
    }
}
