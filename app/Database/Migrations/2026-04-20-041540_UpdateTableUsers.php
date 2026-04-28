<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTableUsers extends Migration
{
    public function up()
    {
        $fields = [
            'isLoggedIn' => [
                'type' => 'BOOLEAN',
                'default' => false
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'isLoggedIn');
    }
}
