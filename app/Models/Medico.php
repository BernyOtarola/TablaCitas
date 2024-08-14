<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Medico extends Model
{
    use HasFactory;

    protected $table = 'medicos';
    protected $primaryKey = 'idMedicos';

    // Relación con especialidades a través de la tabla pivote 'especidadesmedico'
    public function especialidades()
    {
        return $this->belongsToMany(Especialidad::class, 'especidadesmedico', 'medico', 'especilidad');
    }

    public function sucursales()
    {
        return $this->belongsToMany(Sucursal::class, 'sucursalesmedicos', 'medico', 'sucursal');
    }


    // Relación con horarios
    public function horarios()
    {
        return $this->hasMany(HorarioMedico::class, 'idSucursalMedico', 'idMedicos');
    }



    protected static function booted()
    {
        static::created(function ($medico) {
            $medico->generarHorarios();
        });
    }

    public function generarHorarios()
    {
        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        foreach ($dias as $dia) {
            // Horarios de la mañana: 8:00 a 11:00 (intervalos de 30 minutos)
            $this->crearHorarios($dia, '08:00:00', '11:00:00');

            // Horarios de la tarde: 13:00 a 17:00 (intervalos de 30 minutos)
            $this->crearHorarios($dia, '13:00:00', '17:00:00');
        }
    }

    private function crearHorarios($dia, $horaInicio, $horaFin)
    {
        $inicio = Carbon::createFromTimeString($horaInicio);
        $fin = Carbon::createFromTimeString($horaFin);

        while ($inicio->lessThan($fin)) {
            HorarioMedico::create([
                'medico_id' => $this->id,
                'dia' => $dia,
                'hora_inicio' => $inicio->format('H:i:s'),
                'hora_fin' => $inicio->copy()->addMinutes(30)->format('H:i:s'),
                'disponible' => true,
            ]);
            $inicio->addMinutes(30);
        }
    }








}
