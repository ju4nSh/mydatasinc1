<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;
class UserSeeder extends Seeder
{
    public function run()
    {
        // $this->db->table('users')->emptyTable();
        $faker = Factory::create();
        
        
        //user alex
        $nombre = 'alex';
        $apellido = 'rodriguez';
        $data = [
            'Identificacion' => 105604925, 
            'Nombre' => $nombre,
            'Apellido' => $apellido,
            'Correo' => $faker->email,
            'Direccion' => $faker->streetAddress,
            'Ciudad' => $faker->city,
            'Pais' => $faker->country,
            'SobreMi' => $faker->sentence($nbWords = 6, $variableNbWords = true),
            'Usuario' => $nombre. '-' . $apellido,
            'Password' => password_hash(12345678, PASSWORD_DEFAULT),
            'Creator' => $faker->randomElement([1, 0]),
            'Foto' => $faker->imageUrl($width = 640, $height = 480),
            'Rol' => 0,
            'userid' => '833930674',
        ];
        $this->db->table('users')->insert($data);


        // $roles = $this->db->table('roles')->select('identificacion')->get();
        // $users = $this->db->table('users')->select('id')->get();
        // for ($i = 0; $i < 10; $i++) {
        //     $nombre = $faker->name;
        //     $apellido = $faker->lastName;
        //     $data = [
        //         'Identificacion' => $faker->unique()->isbn10, 
        //         'Nombre' => $nombre,
        //         'Apellido' => $apellido,
        //         'Correo' => $faker->email,
        //         'Direccion' => $faker->streetAddress,
        //         'Ciudad' => $faker->city,
        //         'Pais' => $faker->country,
        //         'SobreMi' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        //         'Usuario' => $nombre. '-' . $apellido,
        //         'Password' => password_hash(12345678, PASSWORD_DEFAULT),
        //         'Creator' => $faker->randomElement(array_column($users->getResultArray(), 'id')),
        //         'Foto' => $faker->imageUrl($width = 640, $height = 480),
        //         'Rol' => $faker->randomElement(array_column($roles->getResultArray(), 'identificacion')),
        //         'userid' => $faker->randomElement(['833930674', '833930674']),
        //         // "dateProductUpdated" => $faker->dateTime()
        //     ];
        //     // print_r($data);
        //     $this->db->table('users')->insert($data);
        // }

        
        $this->call('ClienteSeeder');
    }
}
