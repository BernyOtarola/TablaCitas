<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitaController;

// Página de inicio
Route::get('/', [CitaController::class, 'home'])->name('citas.home');

// Formularios de login y registro
Route::get('/login', [CitaController::class, 'showLoginForm'])->name('citas.showLoginForm');
Route::post('/login', [CitaController::class, 'checkLogin'])->name('citas.checkLogin');
Route::get('/register', [CitaController::class, 'showRegistrationForm'])->name('citas.showRegistrationForm');
Route::post('/register', [CitaController::class, 'register'])->name('citas.register');

// Rutas CRUD para el recurso `Cita`
Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');               // Mostrar todas las citas
Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');      // Mostrar formulario para crear una nueva cita
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');              // Almacenar una nueva cita en la base de datos
Route::get('/citas/{id}/edit', [CitaController::class, 'edit'])->name('citas.edit');       // Mostrar formulario para editar una cita existente
Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');        // Actualizar una cita existente en la base de datos
Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');   // Eliminar una cita existente de la base de datos

// Rutas AJAX para obtener datos dinámicamente
Route::get('/especialidades/{sucursalId}', [CitaController::class, 'getEspecialidadesPorSucursal']);
Route::get('/medicos/{especialidadId}', [CitaController::class, 'ObtenerListaDeMedicosPorEspecialidad']);
Route::get('/fechas/{medicoId}', [CitaController::class, 'getFechasByMedico']);
Route::get('/horas/{medicoId}/{fecha}', [CitaController::class, 'getHorasByMedicoFecha']);

// Confirmación de citas
Route::get('/citas/confirm', [CitaController::class, 'confirm'])->name('citas.confirm');

// Ruta para obtener especialidades por médico
Route::get('/especialidades-por-medico', [CitaController::class, 'getEspecialidadesPorMedico']);

//TODO: test para json
Route::get('/especialidadEspecifica/{id}',[CitaController::class, 'getEspecialidadesPorSucursal']);
Route::get('/listaMedicosPorEspecialidad/{id}',[CitaController::class, 'ObtenerListaDeMedicosPorEspecialidad']);
Route::get('/validar-disponibilidad', [CitaController::class, 'obtenerHorariosMedicos']);
