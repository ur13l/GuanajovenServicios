@extends('layout.app')

@section('title')
    Cambiar Contraseña
@endsection

@section('cabecera')
    Nueva Contraseña
@endsection

@section('contenedor')
    <div class="row">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <h5>Su contraseña se ha restablecido con éxito. </h5>
    </div>
    <script type="text/javascript">
        $('.nav-wrapper').find('ul').remove();
    </script>
@endsection
