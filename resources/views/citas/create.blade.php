@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agendar Cita</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('citas.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="cedula">Cédula del Paciente</label>
            <input type="text" name="cedula" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="fechaActual">Fecha Actual</label>
            <input type="text" name="fechaActual" class="form-control" value="{{ $fechaActual }}" readonly required>
        </div>

        <div class="form-group">
            <label for="sucursal">Sucursal</label>
            <select name="sucursal" class="form-control" id="sucursal" required>
                <option value="">Seleccione una Sucursal</option>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}">{{ $sucursal->nomSucursal }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="especialidad">Especialidad</label>
            <select name="especialidad" class="form-control" id="especialidad" required>
                <option value="">Seleccione una Especialidad</option>
            </select>
        </div>

        <div class="form-group">
            <label for="medico">Médico</label>
            <select name="medico" class="form-control" id="medico" required>
                <option value="">Seleccione un Médico</option>
            </select>
        </div>

        <div class="form-group">
            <label for="fechaCita">Fecha de la Cita</label>
            <input type="date" name="fechaCita" class="form-control" id="fechaCita" required>
        </div>

        <div class="form-group">
            <label for="horaCita">Hora de la Cita</label>
            <select name="horaCita" class="form-control" id="horaCita" required>
                <option value="">Seleccione una Hora</option>
                <!-- Horarios por defecto -->
                <option value="08:00">08:00 AM</option>
                <option value="08:30">08:30 AM</option>
                <option value="09:00">09:00 AM</option>
                <option value="09:30">09:30 AM</option>
                <option value="10:00">10:00 AM</option>
                <option value="10:30">10:30 AM</option>
                <option value="11:00">11:00 AM</option>
                <option value="11:30">11:30 AM</option>
                <option value="13:00">01:00 PM</option>
                <option value="13:30">01:30 PM</option>
                <option value="14:00">02:00 PM</option>
                <option value="14:30">02:30 PM</option>
                <option value="15:00">03:00 PM</option>
                <option value="15:30">03:30 PM</option>
                <option value="16:00">04:00 PM</option>
                <option value="16:30">04:30 PM</option>
            </select>
        </div>

        <div class="form-group">
            <label for="motivo">Motivo de la Cita</label>
            <textarea name="motivo" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Agendar Cita</button>
    </form>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sucursal').change(function() {
            var sucursalId = $(this).val();
            if (sucursalId) {
                $.ajax({
                    url: '/especialidades/' + sucursalId,
                    type: 'GET',
                    success: function(data) {
                        $('#especialidad').empty().append('<option value="">Seleccione una Especialidad</option>');
                        $.each(data, function(key, value) {
                            $('#especialidad').append('<option value="' + value.id + '">' + value.nombre + '</option>');
                        });
                        $('#medico').empty().append('<option value="">Seleccione un Médico</option>');
                    }
                });
            } else {
                $('#especialidad').empty().append('<option value="">Seleccione una Especialidad</option>');
                $('#medico').empty().append('<option value="">Seleccione un Médico</option>');
            }
        });

        $('#especialidad').change(function() {
            var especialidadId = $(this).val();
            if (especialidadId) {
                $.ajax({
                    url: '/medicos/' + especialidadId,
                    type: 'GET',
                    success: function(data) {
                        $('#medico').empty().append('<option value="">Seleccione un Médico</option>');
                        $.each(data, function(key, value) {
                            $('#medico').append('<option value="' + value.idMedicos + '">' + value.nombre + ' ' + value.apellido1 + '</option>');
                        });
                    }
                });
            } else {
                $('#medico').empty().append('<option value="">Seleccione un Médico</option>');
            }
        });

        $('#medico').change(function() {
            // Aquí puedes habilitar la hora por defecto si lo deseas
            $('#horaCita').prop('disabled', false);
        });

        $('#horaCita').change(function() {
            // No se realiza ninguna validación en el frontend para mostrar u ocultar horarios
            // Todo se valida en el backend
        });
    });
</script>
@endsection
@endsection
