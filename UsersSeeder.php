<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'email'    => 'admin@example.com',
            'password' => 'admin123',
        ];

        $this->db->table('users')->insert($data);
    }
}
