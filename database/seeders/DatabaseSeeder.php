<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            MedicosSeeder::class, 
            EspecialidadesSucursalSeeder::class,
            EspecialidadesMedicoSeeder::class,
            SucursalesMedicosSeeder::class,
            HorariosMedicosSeeder::class,
        ]);
    }
}
