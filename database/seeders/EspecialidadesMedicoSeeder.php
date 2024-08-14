<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EspecialidadesMedicoSeeder extends Seeder
{
    public function run()
    {
        DB::table('especidadesmedico')->insert([
            [
                'especilidad' => 1,
                'medico' => 1,
            ],
            [
                'especilidad' => 2,
                'medico' => 1,
            ],
            [
                'especilidad' => 1,
                'medico' => 2,
            ],
            [
                'especilidad' => 3,
                'medico' => 2,
            ],

        ]);
    }
}

