<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursal';
    protected $primaryKey = 'id';

    public function especialidades()
    {
        return $this->hasMany(EspecialidadSucursal::class, 'sucursal', 'id');
    }
    public function medicos()
    {
        return $this->hasManyThrough(Medico::class, SucursalesMedicos::class, 'sucursal', 'idMedicos', 'id', 'medico');
    }
}
