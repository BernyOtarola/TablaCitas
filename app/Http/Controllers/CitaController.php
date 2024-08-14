<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Paciente;
use App\Models\Sucursal;
use App\Models\Especialidad;
use App\Models\Medico;
use App\Models\HorarioMedico;
use App\Models\EspecialidadSucursal;
use App\Models\EspecialidadMedico;
use Carbon\Carbon;

class CitaController extends Controller
{
    private $provincias = [
        'San José',
        'Alajuela',
        'Cartago',
        'Heredia',
        'Guanacaste',
        'Puntarenas',
        'Limón'
    ];

    private $cantones = [
        'San José' => ['San José', 'Escazú', 'Desamparados', 'Puriscal', 'Tarrazú', 'Aserrí', 'Mora', 'Goicoechea', 'Santa Ana', 'Alajuelita', 'Vázquez de Coronado', 'Acosta', 'Tibás', 'Moravia', 'Montes de Oca', 'Turrubares', 'Dota', 'Curridabat', 'Pérez Zeledón', 'León Cortés'],
        'Alajuela' => ['Alajuela', 'San Ramón', 'Grecia', 'San Mateo', 'Atenas', 'Naranjo', 'Palmares', 'Poás', 'Orotina', 'San Carlos', 'Zarcero', 'Valverde Vega', 'Upala', 'Los Chiles', 'Guatuso'],
        'Cartago' => ['Cartago', 'Paraíso', 'La Unión', 'Jiménez', 'Turrialba', 'Alvarado', 'Oreamuno', 'El Guarco'],
        'Heredia' => ['Heredia', 'Barva', 'Santo Domingo', 'Santa Bárbara', 'San Rafael', 'San Isidro', 'Belén', 'Flores', 'San Pablo', 'Sarapiquí'],
        'Guanacaste' => ['Liberia', 'Nicoya', 'Santa Cruz', 'Bagaces', 'Carrillo', 'Cañas', 'Abangares', 'Tilarán', 'Nandayure', 'La Cruz', 'Hojancha'],
        'Puntarenas' => ['Puntarenas', 'Esparza', 'Buenos Aires', 'Montes de Oro', 'Osa', 'Quepos', 'Golfito', 'Coto Brus', 'Parrita', 'Corredores', 'Garabito'],
        'Limón' => ['Limón', 'Pococí', 'Siquirres', 'Talamanca', 'Matina', 'Guácimo']
    ];

    public function home()
    {
        return view('citas.home');
    }

    // Mostrar todas las citas
    public function index()
    {
        // Obtener todas las citas para mostrarlas en la vista
        $citas = Cita::all();
        return view('citas.index', compact('citas'));
    }


    // Mostrar formulario de login para agendar cita
    public function showLoginForm()
    {
        $sucursales = Sucursal::all();
        $provincias = $this->provincias;
        $cantones = $this->cantones;

        return view('citas.login', compact('sucursales', 'provincias', 'cantones'));
    }


    // Verificar el login del paciente
    public function checkLogin(Request $request)
    {
        $request->validate([
            'tipoIdentificacion' => 'required|string',
            'cedula' => 'required|string',
            'fechaNac' => 'required|date',
        ]);

        $paciente = Paciente::where('cedula', $request->cedula)
            ->where('fechNac', $request->fechaNac)
            ->first();

        if ($paciente) {
            // Guardar el ID del paciente en la sesión para usarlo más adelante
            session(['paciente_id' => $paciente->cedula]);
            return redirect()->route('citas.create');
        } else {
            return redirect()->route('citas.showLoginForm')->with('error', 'No estás registrado. Por favor, <a href="' . route('citas.showRegistrationForm') . '">regístrate aquí</a>.');
        }
    }

    // Mostrar formulario para registrar un nuevo paciente
    public function showRegistrationForm()
    {
        $sucursales = Sucursal::all();
        $provincias = $this->provincias;
        $cantones = $this->cantones; // Añadido aquí
        return view('citas.register', compact('sucursales', 'provincias', 'cantones'));
    }
    public function register(Request $request)
    {
        $request->validate([
            'cedula' => 'required|string|unique:paciente',
            'nombre' => 'required|string',
            'direccion' => 'required|string',
            'genero' => 'required|string',
            'fechNac' => 'required|date',
            'ocupacion' => 'required|string',
            'telefono1' => 'required|numeric', // Validar que sea numérico
            'telefono2' => 'nullable|numeric', // Validar que sea numérico si está presente
            'email' => 'required|email',
            'provincia' => 'required|string',
            'canton' => 'required|string',
            'sucursal' => 'required|integer',
        ]);

        $data = $request->all();
        $data['fechaIngreso'] = date('Y-m-d'); // Agregar la fecha actual como fecha de ingreso

        $paciente = new Paciente($data);
        $paciente->save();

        // Guardar el ID del paciente en la sesión para usarlo más adelante
        session(['paciente_id' => $paciente->cedula]);

        return redirect()->route('citas.create')->with('success', 'Paciente registrado exitosamente. Ahora puede agendar su cita.');
    }

    // Obtener especialidades por sucursal
    public function getEspecialidadesPorSucursal($sucursalId)
    {
        // Corrige el nombre de la columna 'sucursal_id' a 'sucursal'
        $especialidades = Especialidad::whereHas('sucursales', function ($query) use ($sucursalId) {
            $query->where('sucursal', $sucursalId);
        })->get();

        return response()->json($especialidades);
    }

    public function getMedicosPorEspecialidad($especialidadId)
    {
        $medicos = Medico::whereHas('especialidades', function ($query) use ($especialidadId) {
            $query->where('especialidad', $especialidadId);
        })->get();

        return response()->json($medicos);
    }


    //lista de medicos segun especialidad
    public function ObtenerListaDeMedicosPorEspecialidad($especialidadId)
    {
        // Obtener la especialidad correspondiente por ID
        $especialidad = Especialidad::findOrFail($especialidadId);

        // Obtener la lista de médicos asociados a esta especialidad
        $medicos = $especialidad->medicos()->where('activo', 1)->get();

        // Retornar la lista de médicos en formato JSON
        return response()->json($medicos);
    }


    public function ObtenerEspecialidadPorId(Request $request)
    {
        // Valida que se reciba un ID de médico
        $request->validate([
            'medico_id' => 'required|exists:medicos,idMedicos',
        ]);

        // Obtén el ID del médico desde la solicitud
        $medicoId = $request->input('medico_id');


        // Obtén las especialidades asociadas con el médico
        $especialidades = Especialidad::whereHas('medicos', function ($query) use ($medicoId) {
            $query->where('medico', $medicoId);
        })->get();



        // Devuelve las especialidades en formato JSON
        return response()->json($especialidades);
    }

    // Obtener fechas disponibles por médico
    public function getFechasByMedico($medicoId)
    {
        $fechas = HorarioMedico::where('idSucursalMedico', $medicoId)
            ->groupBy('fecha')
            ->pluck('fecha');

        return response()->json($fechas);
    }

    // Obtener horas disponibles por médico y fecha
    public function getHorasByMedicoFecha($medicoId, $fecha)
    {
        $horas = HorarioMedico::where('idSucursalMedico', $medicoId)
            ->where('fecha', $fecha)
            ->pluck('hora');

        return response()->json($horas);
    }

    // Mostrar formulario para crear una nueva cita
    public function create()
    {
        $fechaActual = now()->toDateString();
        $sucursales = Sucursal::all();
        $especialidades = Especialidad::all();
        $especialidades = Especialidad::where('activo', 1)->get(); // Solo las especialidades activas
        $medicos = Medico::all();

        return view('citas.create', compact('fechaActual', 'sucursales', 'especialidades', 'medicos'));
    }

    public function obtenerHorariosMedicos(Request $request)
    {
        $medicoId = $request->input('medico_id');
        $fecha = $request->input('fecha');

        // Obtener todas las horas ocupadas para el médico y la fecha seleccionados
        $horasOcupadas = Cita::where('medico', $medicoId)
            ->where('fechaCita', $fecha)
            ->pluck('horaCita');

        return response()->json($horasOcupadas);
    }

    // Almacenar una nueva cita en la base de datos
    // Almacenar una nueva cita en la base de datos
    public function store(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        //'cedula' => 'required|exists:paciente,cedula',
        'fechaActual' => 'required|date',
        'sucursal' => 'required|integer',
        'especialidad' => 'required|integer',
        'medico' => 'required|integer',
        'fechaCita' => 'required|date',
        'horaCita' => 'required|date_format:H:i',
        'motivo' => 'nullable|string|max:255',
    ]);

    // Crear la cita
    Cita::create([
        'paciente' => $request->cedula,
        'fechaActual' => $request->fechaActual,
        'fechaCita' => $request->fechaCita,
        'horaCita' => $request->horaCita,
        'sucursal' => $request->sucursal,
        'especialidad' => $request->especialidad,
        'medico' => $request->medico,
        'motivo' => $request->motivo,
        'estado' => 'pendiente'
    ]);

    return redirect()->route('citas.index')->with('success', 'Cita agendada con éxito.');
}






    // Mostrar formulario para editar una cita existente
    public function edit($id) //TODO: ORIGINAL
    {
        // Encuentra la cita por su ID
        $cita = Cita::findOrFail($id);

        // Obtén las listas para sucursales, especialidades y médicos
        $sucursales = Sucursal::all();
        $especialidades = Especialidad::all();
        $medicos = Medico::all();

        // Pasa la cita y las listas a la vista
        return view('citas.edit', compact('cita', 'sucursales', 'especialidades', 'medicos'));
    }



    // Actualizar una cita existente en la base de datos
    public function update(Request $request, $id)
    {

        $request->validate([
            'fechaCita' => 'required|date_format:Y-m-d H:i:s', // Validación para fecha con formato específico
            'horaCita' => 'required|date_format:H:i:s', // Validación para hora con formato específico
            'sucursal' => 'required|integer|exists:sucursal,id', // Verifica que la sucursal exista en la tabla `sucursal`
            'especialidad' => 'required|integer|exists:especialidades,id', // Verifica que la especialidad exista en la tabla `especialidades`
            'medico' => 'required|integer|exists:medicos,idMedicos', // Verifica que el médico exista en la tabla `medicos`
            'motivo' => 'nullable|string|max:255', // Campo opcional con un máximo de 255 caracteres
            'estado' => 'nullable|string|max:255' // Campo opcional con un máximo de 255 caracteres
        ]);



        $cita = Cita::findOrFail($id);

        $cita->fechaCita = $request->fechaCita;
        $cita->horaCita = $request->horaCita;
        $cita->sucursal = $request->sucursal;
        $cita->especialidad = $request->especialidad;
        $cita->medico = $request->medico;
        $cita->motivo = $request->motivo;
        $cita->estado = $request->estado;



        $cita->save();

        return redirect('/citas')->with('success', 'Cita actualizada exitosamente');
    }

    // Eliminar una cita existente de la base de datos
    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return redirect('/citas')->with('success', 'Cita eliminada exitosamente');
    }

    // Método para mostrar el mensaje de confirmación
    public function confirm()
    {
        return view('citas.confirm');
    }

}
