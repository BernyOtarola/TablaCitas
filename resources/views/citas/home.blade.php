
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Bienvenido a Clínica Dental Dentico') }}</div>

                <div class="card-body">
                    <a href="{{ route('citas.create') }}" class="btn btn-primary">Agendar Cita</a>
                    <a href="{{ route('citas.index') }}" class="btn btn-secondary">Ver Citas</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
