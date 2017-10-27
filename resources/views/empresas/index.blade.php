@extends('layout.app')

@section('title')
    Empresas
@endsection

@section('cabecera')
    Empresas
@endsection

@section('head')
    <script src="{{url('/js/empresas/index.js')}}"></script>
@endsection

@section('contenedor')
    <!--Modal eliminar-->
    <div id="deleteModalConv" class="modal">
        <form action="{{url('/empresas/eliminar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar la empresa?</p>
                <input type="hidden" name="id-eliminar" id="id-eliminar">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>

    <div class="row">
    @foreach($empresas as $empresa)
        <div class="col s12 m6 l4 anuncio">
            <a href="{{url("/empresas/editar/$empresa->id_empresa")}}">
                <div class="card">
                    <div class="card-image">
                        <div class="center-cropped"
                             >
                            <img src="{{$empresa->logo}}" />
                        </div>
                        <span class="card-title" style="background: black;">{{$empresa->empresa}}</span>
                        <a data-id="{{$empresa->id_empresa}}" class="btn-floating halfway-fab waves-effect waves-light red right deleteP"><i class="material-icons">clear</i></a>
                    </div>
                </div>
            </a>
        </div>
    @endforeach

    <!-- Cuando no se encuentra ninguna convocatoria -->
        @if(count($empresas) == 0 )
            <p class="s12 center-align">No se encontraron empresas, para agregar una presione el botón +</p>
        @endif
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('empresas/nueva')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
            style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>


@endsection
