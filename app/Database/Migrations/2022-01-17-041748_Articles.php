<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use phpDocumentor\Reflection\Type;

class Articles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 255,
                'auto_increment' => true
            ],
            'judul_artikel' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'isi_artikel' => [
                'type' => 'TEXT',
            ],
            'thumbnail_artikel' => [
                'type' => 'TEXT',
                'null' => false
            ],
            'tag_artikel' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'kategori_artikel' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ]
        ]);

        $this->forge->addPrimaryKey('id',TRUE);
        $this->forge->createTable('articles',TRUE);

    }

    public function down()
    {
        $this->forge->dropDatabase('articles');
    }
}
