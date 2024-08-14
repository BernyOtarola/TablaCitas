<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
        public function up()
        {
            Schema::create('horariosmedicos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('medico_id')->constrained('medicos')->onDelete('cascade');
                $table->string('dia'); // Día de la semana
                $table->time('hora_inicio'); // Hora de inicio de la franja horaria
                $table->time('hora_fin'); // Hora de fin de la franja horaria
                $table->boolean('disponible')->default(true); // Para marcar si la franja horaria está disponible o no
                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('horariosmedicos');
        }
    
};
