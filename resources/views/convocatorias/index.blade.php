@extends('layout.app')

@section('title')
    Convocatorias
@endsection

@section('cabecera')
    Convocatorias
@endsection

@section('head')
    <script src="{{url('/js/convocatorias/index.js')}}"></script>
@endsection

@section('contenedor')
    <!--Modal eliminar-->
    <div id="deleteModalConv" class="modal">
        <form action="{{url('/convocatorias/eliminar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar la convocatoria?</p>
                <input type="hidden" name="id-eliminar" id="id-eliminar">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" id="cancelBtn" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>

    <div class="row">
    @foreach($convocatorias as $convocatoria)
        <div class="col s12 m6 l4 anuncio">
            <a href="{{url("/convocatorias/editar/$convocatoria->id_convocatoria")}}">
                <div class="card">
                    <div class="card-image">
                        <div class="center-cropped">
                            <img src="{{$convocatoria->ruta_imagen}}" />
                        </div>
                        <span class="card-title" style="background: black;">{{$convocatoria->titulo}}</span>
                        <a data-id="{{$convocatoria->id_convocatoria}}" class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    <!-- Cuando no se encuentra ninguna convocatoria -->
        @if(count($convocatorias) == 0 )
            <p class="s12 center-align">No se encontraron convocatorias, para agregar uno presione el botón +</p>
        @endif
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('convocatorias/nueva')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
            style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>


@endsection
