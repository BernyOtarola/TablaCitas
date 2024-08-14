<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecialidadSucursal extends Model
{
    use HasFactory;

    protected $table = 'especialidadessucursal';

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad', 'id');
    }

    public function medicos()
    {
        return $this->hasManyThrough(Medico::class, EspecialidadMedico::class, 'especialidad', 'idMedicos', 'especialidad', 'medico');
    }
}
