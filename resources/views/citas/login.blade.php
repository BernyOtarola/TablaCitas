@extends('layouts.app')

@section('content')
<div class="login-container">
    <h1>Solicitud de citas</h1>
    <p class="text-center">Ingresa tu número de identificación y fecha de nacimiento. Si eres extranjero ingresa tu número de carné de residente y fecha de nacimiento.</p>
    <form action="{{ route('citas.checkLogin') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="tipoIdentificacion">Tipo de identificación:</label>
            <select name="tipoIdentificacion" class="form-control" required>
                <option value="">Seleccione una opción...</option>
                <option value="nacional">Cédula Nacional</option>
                <option value="extranjero">Carné de Residente</option>
            </select>
        </div>
        <div class="form-group">
            <label for="cedula">Número de identificación:</label>
            <input type="text" name="cedula" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="fechaNac">Fecha de nacimiento:</label>
            <input type="date" name="fechaNac" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
    </form>
    <div class="register-link">
        <p>¿Eres un paciente nuevo? <a href="#" data-toggle="modal" data-target="#registerModal">Regístrese aquí</a></p>
    </div>
</div>

<!-- Modal de Registro -->
<div class="modal fade modal-horizontal" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Registro de Paciente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('citas.register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="cedula">Cédula</label>
                        <input type="text" name="cedula" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="genero">Género</label>
                        <select name="genero" class="form-control" required>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fechNac">Fecha de Nacimiento</label>
                        <input type="date" name="fechNac" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="ocupacion">Ocupación</label>
                        <input type="text" name="ocupacion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono1">Teléfono 1</label>
                        <input type="text" name="telefono1" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono2">Teléfono 2</label>
                        <input type="text" name="telefono2" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="provincia">Provincia</label>
                        <select name="provincia" class="form-control" id="provincia" required>
                            @foreach($provincias as $provincia)
                                <option value="{{ $provincia }}">{{ $provincia }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="canton">Cantón</label>
                        <select name="canton" class="form-control" id="canton" required></select>
                    </div>
                    <div class="form-group">
                        <label for="sucursal">Sucursal</label>
                        <select name="sucursal" class="form-control" required>
                            @foreach($sucursales as $sucursal)
                                <option value="{{ $sucursal->id }}">{{ $sucursal->nomSucursal }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#provincia').change(function() {
            var provincia = $(this).val();
            var cantones = @json($cantones);
            $('#canton').empty();
            $.each(cantones[provincia], function(index, canton) {
                $('#canton').append('<option value="' + canton + '">' + canton + '</option>');
            });
        });
    });
</script>
@endsection
