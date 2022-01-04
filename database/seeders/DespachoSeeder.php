<?php

namespace Database\Seeders;
use App\Models\Despacho;

use Illuminate\Database\Seeder;

class DespachoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Despacho::create([
            'nombre' => 'VyV Abogados S.A',
            'ruc' => '0104649843001',
            'direccion' => 'davila chica, gualaceo',
            'email' => 'vyvabogados@gmail.com',
            'telefono' => '2255181'

        ]);
    }
}
