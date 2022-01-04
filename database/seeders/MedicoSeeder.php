<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medico;

class MedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Medico::create([
            'nombre' => 'juan perez',
            'ci' => '01045677',
            'telefono' => '072255181',
            'email' => 'medico@gmail.com',
            'direccion' => 'centro',

        ]);

        Medico::create([
            'nombre' => 'maria luecero',
            'ci' => '01045677',
            'telefono' => '072255181',
            'email' => 'lucero@gmail.com',
            'direccion' => 'centro',

        ]);


    }
}
