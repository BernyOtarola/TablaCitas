@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Cita</h1>
    <form action="{{ route('citas.update', $cita->idCitas) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="sucursal">Sucursal</label>
            <select name="sucursal" id="sucursal" class="form-control">
                @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}" {{ $cita->sucursal == $sucursal->id ? 'selected' : '' }}>
                    {{ $sucursal->nomSucursal }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <select name="especialidad" id="especialidad" class="form-control" {{ $cita->especialidad ? '' : 'disabled' }}>
                @foreach($especialidades as $especialidad)
                <option value="{{ $especialidad->id }}" {{ $cita->especialidad == $especialidad->id ? 'selected' : '' }}>
                    {{ $especialidad->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="medico">Médico</label>
            <select name="medico" id="medico" class="form-control" {{ $cita->medico ? '' : 'disabled' }}>
                @foreach($medicos as $medico)
                <option value="{{ $medico->idMedicos }}" {{ $cita->medico == $medico->idMedicos ? 'selected' : '' }}>
                    {{ $medico->nombre }} {{ $medico->apellido1 }} {{ $medico->apellido2 }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fechaCita">Fecha de la Cita</label>
            <select name="fechaCita" id="fechaCita" class="form-control" {{ $cita->fechaCita ? '' : 'disabled' }}>
                <option value="{{ $cita->fechaCita }}">{{ $cita->fechaCita }}</option>
                <!-- Opciones llenadas por AJAX -->
            </select>
        </div>
        <div class="form-group">
            <label for="horaCita">Hora de la Cita</label>
            <select name="horaCita" id="horaCita" class="form-control" {{ $cita->horaCita ? '' : 'disabled' }}>
                <option value="{{ $cita->horaCita }}">{{ $cita->horaCita }}</option>
                <!-- Opciones llenadas por AJAX -->
            </select>
        </div>
        <div class="form-group">
            <label for="motivo">Motivo</label>
            <input type="text" name="motivo" class="form-control" value="{{ $cita->motivo }}">
        </div>
        <div class="form-group">
            <label for="estado">Estado</label>
            <input type="text" name="estado" class="form-control" value="{{ $cita->estado }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sucursalSelect = document.getElementById('sucursal');
    const especialidadSelect = document.getElementById('especialidad');
    const medicoSelect = document.getElementById('medico');

    // Escuchar el cambio en el select de sucursal
    sucursalSelect.addEventListener('change', function () {
        const sucursalId = this.value;

        // Resetear los selectores de especialidad y médico
        especialidadSelect.innerHTML = '<option value="">Seleccione una especialidad</option>';
        medicoSelect.innerHTML = '<option value="">Seleccione un médico</option>';
        especialidadSelect.disabled = true;
        medicoSelect.disabled = true;

        if (sucursalId) {
            $.ajax({
                url: '/especialidades/' + sucursalId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    especialidadSelect.innerHTML = '<option value="">Seleccione una especialidad</option>';
                    $.each(data, function(index, especialidad) {
                        especialidadSelect.innerHTML += `<option value="${especialidad.id}">${especialidad.nombre}</option>`;
                    });
                    especialidadSelect.disabled = false;
                },
                error: function() {
                    alert('Error al obtener la lista de especialidades. Inténtelo de nuevo.');
                }
            });
        } else {
            especialidadSelect.innerHTML = '<option value="">Seleccione una sucursal primero</option>';
            medicoSelect.innerHTML = '<option value="">Seleccione una especialidad primero</option>';
            especialidadSelect.disabled = true;
            medicoSelect.disabled = true;
        }
    });

    // Escuchar el cambio en el select de especialidad
    especialidadSelect.addEventListener('change', function () {
        const especialidadId = this.value;
        medicoSelect.innerHTML = '';
        medicoSelect.disabled = true;

        if (especialidadId) {
            $.ajax({
                url: '/listaMedicosPorEspecialidad/' + especialidadId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    medicoSelect.innerHTML = '<option value="">Seleccione un médico</option>';
                    $.each(data, function(index, medico) {
                        medicoSelect.innerHTML += `<option value="${medico.idMedicos}">${medico.nombre} ${medico.apellido1} ${medico.apellido2}</option>`;
                    });
                    medicoSelect.disabled = false;
                },
                error: function() {
                    alert('Error al obtener la lista de médicos. Inténtelo de nuevo.');
                }
            });
        } else {
            medicoSelect.innerHTML = '<option value="">Seleccione una especialidad primero</option>';
            medicoSelect.disabled = true;
        }
    });
});
</script>

@endsection
