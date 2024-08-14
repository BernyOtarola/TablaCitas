<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades'; // Nombre de la tabla en la base de datos
    protected $fillable = ['nombre', 'descripcion', 'activo'];
    protected $primaryKey = 'id'; // Nombre de la clave primaria
    public $timestamps = false; // Si no estás utilizando las columnas created_at y updated_at

    // Relación con citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'especialidad', 'id');
    }

    // Relación con médicos a través de la tabla pivote 'especidadesmedico'
    public function medicos()
    {
        return $this->belongsToMany(Medico::class, 'especidadesmedico', 'especilidad', 'medico');
    }

    public function sucursales()
    {
        return $this->hasMany(EspecialidadSucursal::class, 'especialidad', 'id');
    }
}
