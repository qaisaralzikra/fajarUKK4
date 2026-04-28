<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnJumlahBukuInTransaksiTable extends Migration
{
    public function up()
    {
        $fields = [
            'jumlah_buku' => [
                'type'       => 'INT',
                'constraint' => 255,
                'null'       => true, // Lebih aman daripada default string kosong
            ],
        ];

        $this->forge->addColumn('transaksi', $fields);
    }

    public function down()
    {
        // Menggunakan array untuk drop banyak kolom sekaligus lebih efisien
        $this->forge->dropColumn('transaksi', 'jumlah_buku');
    }
}
