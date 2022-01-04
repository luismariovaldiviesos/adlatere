<?php

namespace Database\Seeders;
use App\Models\Clinica;

use Illuminate\Database\Seeder;

class ClinicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clinica::create([
            'nombre'=> 'Mel Dental',
            'direccion' => 'Gualaceo',
            'telefono' => '2255183',
            'ruc' => '0102649843001',
            'email' => 'meldental@gmail',
            'image' => 'noimg.jpg'
        ]);
    }
}
