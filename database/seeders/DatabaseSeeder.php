<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Arranque limpio: SOLO sistema. El resto (materias, fases, unidades, settings,
// usuarios, clientes, juicios, audiencias, consultas) entra por Excel con
// php artisan carga:inicial. Datos demo solo en database/seeders/demo (dev).
class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(SistemaCoreSeeder::class);
        $this->call(PerfilesSeeder::class);
    }
}
