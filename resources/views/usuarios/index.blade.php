@extends('layout.app')

@section('title')
    Usuarios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/usuarios/index.js')}}"></script>
@endsection

@section('cabecera')
    Usuarios
@endsection

@section('contenedor')

    <!-- Cuerpo del index -->
    <div class="row">
    <!--<div class="col s1">
            <div class="fixed-action-btn">
                <a class="btn-floating btn-large waves-effect waves-light" style="background: #BF3364" href="{{url('jovenes/nuevo')}}"><i class="material-icons">add</i></a>
            </div>
        </div>-->
        <div class="col s4 offset-s8">
            <div class="left-align">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input id="icon_search" type="text" class="validate">
                </div>
            </div>
        </div>
    </div>
    @include('usuarios.lista')

    <!--Modal para eliminar usuario-->
    <div id="modal-borrar" class="modal">
        <form action="{{url('/usuarios/borrar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar este elemento?</p>
                <input type="hidden" name="id_usuario" id="id_usuario">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>
@endsection


