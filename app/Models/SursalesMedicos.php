<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalesMedicos extends Model
{
    use HasFactory;

    protected $table = 'sucursalesmedicos';
    protected $primaryKey = 'idSucursalesMedicos';

    // Relación con la tabla `sucursal`
    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal', 'id');
    }

    // Relación con la tabla `medicos`
    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico', 'idMedicos');
    }
}
