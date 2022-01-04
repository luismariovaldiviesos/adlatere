<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidad;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Especialidad::create([
            'nombre' => 'Familia'
        ]);
        Especialidad::create([
            'nombre' => 'Civil'
        ]);
        Especialidad::create([
            'nombre' => 'Penal'
        ]);
        Especialidad::create([
            'nombre' => 'Violencia Intrafamiliar'
        ]);
        Especialidad::create([
            'nombre' => 'Contencioso Administrativo'
        ]);
        Especialidad::create([
            'nombre' => 'Contencioso Tributario'
        ]);
    }
}
