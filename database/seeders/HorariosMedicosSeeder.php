<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HorariosMedicosSeeder extends Seeder
{
    public function run()
    {
        DB::table('horariosmedicos')->insert([
            ['idSucursalMedico' => 1, 'dia' => 'Lunes', 'horaInicio' => '08:00:00', 'horaFin' => '17:00:00'],
            ['idSucursalMedico' => 1, 'dia' => 'Martes', 'horaInicio' => '08:00:00', 'horaFin' => '17:00:00'],
            ['idSucursalMedico' => 2, 'dia' => 'Lunes', 'horaInicio' => '08:00:00', 'horaFin' => '17:00:00'],
            ['idSucursalMedico' => 2, 'dia' => 'Miércoles', 'horaInicio' => '08:00:00', 'horaFin' => '17:00:00'],
        ]);
    }
}
