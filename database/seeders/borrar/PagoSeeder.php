<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pago;

class PagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pago::create([
            'nombre' => 'PAGADO',
            'observaciones' => 'cita pagada'
        ]);

        Pago::create([
            'nombre' => 'PENDIENTE',
            'observaciones' => 'cita pendiente de pago'
        ]);


    }
}
