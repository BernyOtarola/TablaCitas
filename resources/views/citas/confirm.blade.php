
@extends('layouts.app')

@section('content')
<div class="container">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Cita creada exitosamente',
                text: "¿Deseas volver a pedir una cita?",
                icon: 'success',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('citas.create') }}";
                } else {
                    window.location.href = "{{ route('citas.home') }}";
                }
            });
        });
    </script>
</div>
@endsection
