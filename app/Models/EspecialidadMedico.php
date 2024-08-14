<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EspecialidadMedico extends Model
{
    use HasFactory;

    protected $table = 'especidadesmedico';
    protected $primaryKey = 'idEspecidadesMedico';
    protected $fillable = ['medico', 'especilidad'];

    public function medico()
    {
        return $this->belongsTo(Medico::class, 'medico', 'idMedicos');
    }
}
