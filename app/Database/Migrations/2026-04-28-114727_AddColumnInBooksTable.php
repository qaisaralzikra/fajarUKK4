<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnInBooksTable extends Migration
{
    public function up()
    {
        $fields = [
            'deskripsi' => [
                'type'       => 'TEXT',
                'null'       => true, // Lebih aman daripada default string kosong
            ],
            'tanggal_terbit' => [
                'type'       => 'DATE',
                'null'       => true, // Mengizinkan kolom kosong secara resmi di database
            ],
        ];

        $this->forge->addColumn('books', $fields);
    }

    public function down()
    {
        // Menggunakan array untuk drop banyak kolom sekaligus lebih efisien
        $this->forge->dropColumn('books', ['deskripsi', 'tanggal_terbit']);
    }
}
