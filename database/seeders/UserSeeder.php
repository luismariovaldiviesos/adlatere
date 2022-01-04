<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'=> 'Luis Mario',
            'ci' => '0104649843',
            'phone' => '2255181',
            'email' => 'admin@mail.com',
            'profile' => 'administrador',
            'status' => 'ACTIVE',
            'password' => bcrypt('administrador')
        ]);
        User::create([
            'name'=> 'joaquin valdivieso',
            'ci' => '0151349843',
            'phone' => '2255181',
            'email' => 'joaquis@mail.com',
            'profile' => 'administrador',
            'status' => 'ACTIVE',
            'password' => bcrypt('administrador')
        ]);
        User::create([
            'name'=> 'ximena chhocho',
            'ci' => '0103844494',
            'phone' => '2255181',
            'email' => 'ximena@mail.com',
            'profile' => 'empleado',
            'status' => 'ACTIVE',
            'password' => bcrypt('empleado')
        ]);
    }
}
