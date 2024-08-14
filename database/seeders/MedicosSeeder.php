<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicosSeeder extends Seeder
{
    public function run()
    {
        DB::table('medicos')->insert([
            [
                'idMedicos' => 1,
                'nombre' => 'Juan',
                'apellido1' => 'Pérez',
                'apellido2' => 'Gómez',
                'telefono' => 12345678,
                'direccion' => 'Calle 1',
                'email' => 'juan.perez@example.com',
                'fechaRegistro' => '2024-01-01',
                'activo' => 1,
            ],
            [
                'idMedicos' => 2,
                'nombre' => 'María',
                'apellido1' => 'Rodríguez',
                'apellido2' => 'López',
                'telefono' => 87654321,
                'direccion' => 'Avenida 2',
                'email' => 'maria.rodriguez@example.com',
                'fechaRegistro' => '2024-01-02',
                'activo' => 1,
            ],
            [
                'idMedicos' => 3,
                'nombre' => 'Carlos',
                'apellido1' => 'Sánchez',
                'apellido2' => 'Martínez',
                'telefono' => 12348765,
                'direccion' => 'Calle 3',
                'email' => 'carlos.sanchez@example.com',
                'fechaRegistro' => '2024-01-03',
                'activo' => 1,
            ],
            // Añade más datos según sea necesario
        ]);
    }
}
