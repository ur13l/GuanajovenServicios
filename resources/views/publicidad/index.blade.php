@extends('layout.app')

@section('title')
    Publicidad
@endsection

@section('cabecera')
    Publicidad
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/publicidad/index.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
@endsection

@section('contenedor')
    <!--Modal eliminar-->
    <div id="deleteModalPub" class="modal">
        <form action="{{url('/publicidad/eliminar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar la publicidad?</p>
                <input type="hidden" name="id-eliminar" id="id-eliminar">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>

    <!-- Iteración para mostrar los anuncios -->
    @foreach($anuncios as $anuncio)
        <div class="col s12 m12 l12 anuncio" id="ejemplo1">
            <div class="card">
                <div class="card-image">
                    <img src="{{$anuncio->ruta_imagen}}">
                    <span class="card-title" style="background: black; width: 25%;">{{$anuncio->titulo}}</span>
                    <a data-id="{{$anuncio->id_publicidad}}" class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Cuando no se encuentra ningún anuncio -->
    @if(count($anuncios) == 0 )
        <p>No se encontraron anuncios, para agregar uno presione el botón de +</p>
    @endif

    <!--Modal Agregar-->
    <div id="modalPub" class="modal">
        <form action="{{url('/publicidad/crear')}}" method="post" id="form-nuevo" enctype="multipart/form-data" >
        <div class="modal-content">
            <h4>Nueva Publicidad</h4>
            <p>
            <div class="row">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="titulo" name="titulo" type="text" class="vald">
                            <label for="titulo">Título</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="descripcion" name="descripcion" type="text" class="vald">
                            <label for="descripcion">Descripción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="fecha-inicio" name="fecha-inicio" type="text" class="datepicker vald" >
                            <label for="fecha-inicio">Fecha de inicio</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="fecha-fin" type="text" name="fecha-fin" class="datepicker vald" >
                            <label for="fecha-fin">Fecha de fin</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="url" name="url" type="text" class="vald">
                            <label for="url">URL</label>
                        </div>
                    </div>
                    <div class="file-field input-field">
                        <div class="btn rose-code" style="background: #BF3364;">
                            <span>Imagen</span>
                            <input type="file" name="imagen" multiple>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Subir imagen">
                        </div>
                    </div>
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            </p>
        </div>

        <div class="modal-footer">
            <input type="submit" value="Guardar" class="waves-effect waves-green btn-flat">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>

        </form>
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="#modalPub" class="btn-floating btn-large waves-effect waves-light btn modal-trigger" style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>
@endsection

