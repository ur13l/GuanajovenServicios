@extends('layout.app')

@section('title')
    Nueva Convocatoria
@endsection

@section('cabecera')
    Convocatorias
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/convocatorias/nueva.js')}}"></script>
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nueva Convocatoria</h2>
    </div>
    <div class="row">

        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-crear" method="post" action="{{url('/convocatorias/crear')}}" class="col s12" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
                <div class="input-field col s12">
                    <input id="titulo" name="titulo" type="text" class="validate">
                    <label for="titulo">Título</label>
                </div>

                <div class="input-field col s12">
                    <textarea id="descripcion" name="descripcion" class="materialize-textarea"></textarea>
                    <label for="descripcion">Descripción</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_inicio" name="fecha_inicio"  class="datepicker">
                    <label for="fecha_inicio">Fecha de Apertura</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_cierre" name="fecha_cierre"  class="datepicker">
                    <label for="fecha_cierre">Fecha de Cierre</label>
                </div>
                <div class="file-field input-field col s12 l6">
                    <div class="btn" style="background: #BF3364;">
                        <span>Imagen</span>
                        <input type="file" name="imagen" >
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Subir imagen">
                    </div>
                </div>
                <div class="file-field input-field col s12 l6">
                    <div class="btn" style="background: #BF3364;">
                        <span><i class="material-icons left">receipt</i>Documentos</span>
                        <input type="file" name="documentos[]" multiple>
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Cargar documentos">
                    </div>
                </div>

                    <input class="input-field btn right" style="background: #BF3364;" type="submit" value="Registrar">
            </div>


        </form>
    </div>
@endsection
