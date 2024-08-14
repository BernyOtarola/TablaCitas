<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SucursalesMedicosSeeder extends Seeder
{
    public function run()
    {
        DB::table('sucursalesmedicos')->insert([
            ['sucursal' => 1, 'medico' => 1],
            ['sucursal' => 1, 'medico' => 2],
            ['sucursal' => 2, 'medico' => 1],
            ['sucursal' => 2, 'medico' => 3],
        ]);
    }
}
