<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Admin extends Seeder
{
    public function run()
    {
        $data = [
            'username' => 'test',
            'password'    => password_hash('123',PASSWORD_DEFAULT)
        ];

        $this->db->table('admins')->insert($data);
    }
}
