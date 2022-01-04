<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tratamiento;

class TratamientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Tratamiento::create([
            'nombre' => 'blanqueamiento',
            'precio' => 20.00
        ]);

        Tratamiento::create([
            'nombre' => 'calza',
            'precio' => 30.00
        ]);

        Tratamiento::create([
            'nombre' => 'extraccion',
            'precio' => 15.00
        ]);

        Tratamiento::create([
            'nombre' => 'diagnostico',
            'precio' => 20.00
        ]);

    }
}
