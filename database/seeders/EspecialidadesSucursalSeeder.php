<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesSucursalSeeder extends Seeder
{
    public function run()
    {
        DB::table('especialidadessucursal')->insert([
            ['sucursal' => 1, 'especialidad' => 1],
            ['sucursal' => 1, 'especialidad' => 2],
            ['sucursal' => 2, 'especialidad' => 1],
            ['sucursal' => 2, 'especialidad' => 3],
        ]);
    }
}
