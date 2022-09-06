<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('productos');
    }
}
