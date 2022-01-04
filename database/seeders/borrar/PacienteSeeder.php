<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;

class PacienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Paciente::create([
            'nombre' => 'Nestor Mendoza',
            'ci' => '0104649841',
            'telefono' => '072255181',
            'email' => 'nestor@gmail.com',
            'image' => '',
            'direccion' => 'centro',
            'enfermedad' => "",
            'medicamentos' => "",
            'alergias' => "",
        ]);

        Paciente::create([
            'nombre' => 'Manuel Jauregui',
            'ci' => '0104649842',
            'telefono' => '072255181',
            'email' => 'manuel@gmail.com',
            'image' => '',
            'direccion' => 'centro',
            'enfermedad' => "",
            'medicamentos' => "",
            'alergias' => "",
        ]);

        Paciente::create([
            'nombre' => 'Fernando Orellana',
            'ci' => '0104649844',
            'telefono' => '072255181',
            'email' => 'fernando@gmail.com',
            'image' => '',
            'direccion' => 'centro',
            'enfermedad' => "",
            'medicamentos' => "",
            'alergias' => "",
        ]);
    }
}
