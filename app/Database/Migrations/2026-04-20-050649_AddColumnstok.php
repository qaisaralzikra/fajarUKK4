<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnstok extends Migration
{
    public function up()
    {
        $fields = [
            'stok' => [
                'type' => 'INT',
                'constraint' => 255,
                'default' => 0
            ],
        ];

        $this->forge->addColumn('books', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('books', 'stok');
    }
}
