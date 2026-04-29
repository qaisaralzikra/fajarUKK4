<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnfotoandttl extends Migration
{
    public function up()
    {
        $fields = [
            'foto'       => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'ttl' => [
                'type' => 'DATE',
                'null' => true,
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['foto', 'ttl']);
    }
}
