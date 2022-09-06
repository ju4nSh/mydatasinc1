<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('clientes')->emptyTable();
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $data = [
                'nombre' => $faker->name,
                'identificacion' => $faker->isbn10,
                'correo' => $faker->email,
                'direccion' => $faker->streetAddress,
                'estado' => $faker->randomElement([1, 0]),
            ];
            $this->db->table('clientes')->insert($data);
        }
    }
}
