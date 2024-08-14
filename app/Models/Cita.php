<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'idCitas';
    public $timestamps = false;
    public $incrementing = true;
    protected $fillable = [
        'paciente',
        'fechaActual',
        'fechaCita',
        'horaCita',
        'sucursal',
        'especialidad',
        'medico',
        'motivo',
        'estado',
    ];
    protected $casts = [
        'fechaActual' => 'date',
        'fechaCita' => 'date',
        //'horaCita' => 'time',
    ];

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente', 'cedula');
    }

    // Relación con Sucursal
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal', 'id');
    }

    // Relación con Especialidad
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad', 'id');
    }

    // Relación con Medico
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico', 'idMedicos');
    }
}

