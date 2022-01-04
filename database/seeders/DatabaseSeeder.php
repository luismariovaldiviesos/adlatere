<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(EstadoSeeder::class);
        $this->call(PagoSeeder::class);
        $this->call(TratamientoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ClinicaSeeder::class);
        $this->call(MedicoSeeder::class);
        $this->call(PacienteSeeder::class);
        $this->call(RoleSeeder::class);
    }
}
