<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Admins extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 255,
                'auto_increment' => true
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => '55'
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255'
            ]
        ]);

        $this->forge->addPrimaryKey('id',TRUE);
        $this->forge->createTable('admins',TRUE);
    }

    public function down()
    {
        $this->forge->dropDatabase('admins');
    }
}
