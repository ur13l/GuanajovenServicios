@extends('layout.app')

@section('title')
    Servicios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/servicio/editar.js')}}"></script>

@endsection

@section('cabecera')
    Servicios
@endsection

@section('contenedor')
<div class="row">
    <h4>Editar Servicio</h4>
</div>
<div class="row">
    @foreach($errors->all() as $error)
      <div class="red-text">{{$error}}</div>
    @endforeach
    <form id="form-ns" method="post" action="{{url('/servicio/registrar')}}" class="col s12" enctype="multipart/form-data">
        <!--Editar nombres según BD -->
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="capturista" name="capturista" type="text" class="validate">
                <label for="capturista">Capturista</label>
            </div>
            <div class="input-field col s12 m3">
                <input id="id_orden" name="id_orden" type="text" class="validate">
                <label for="id_orden">Id. Orden</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="region_responsable" name="region_responsable" type="text" class="validate">
                <label for="region_responsable">Región responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <input id="centro_poder_joven" name="centro_poder_joven" type="text" class="validate">
                <label for="centro_poder_joven">Centro Poder Joven</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="area_responsable" name="area_responsable" type="text" class="validate">
                <label for="area_responsable">Área responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <input id="usuario_responsable" name="usuario_responsable" type="text" class="validate">
                <label for="usuario_responsable">Usuario responsable</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <div class="autocomplete" id="multiple">
                    <div class="ac-users ac-appender"></div>
                        <div class="ac-input">
                            <input type="text" id="usuarios_involucrados"  data-activates="multipleDropdown" data-beloworigin="true" class="validate" autocomplete="off">
                            <ul id="multipleDropdown" class="dropdown-content ac-dropdown"></ul>
                            <input type="hidden" class="validate">
                        </div>
                        <input type="hidden" name="multipleHidden">
                    </div>
                    <label class="active" for="usuarios_involucrados">Usuarios involucrados </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="joven_beneficiado" name="joven_beneficiado" type="text" class="validate">
                <label for="joven_beneficiado">Joven beneficiado</label>
            </div>
        <!-- Editar-->
            <div class="input-field col s12 m3">
                <input id="tipo_servicio" name="tipo_servicio" type="text" class="validate">
                <label for="tipo_servicio">Tipo de servicio que se brinda</label>
            </div>
        </div>
        <!-- Editar-->
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="beneficiados_relacionados" name="beneficiados_relacionados" type="text" class="validate">
                <label for="beneficiados_relacionados">Beneficiados relacionados</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="titulo" name="titulo" type="text" class="validate">
                <label for="titulo">Título de orden de servicio</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <textarea id="descripcion" name="descripcion" class="materialize-textarea"></textarea>
                <label for="descripcion">Descripción de orden de servicio</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input name="fecha_inicio" id="fecha_inicio" type="text" class="datepicker">
            </div>
            <div class="col s12 m3">
                <label for="fecha_propuesta">Fecha propuesta</label>
                <input name="fecha_propuesta" id="fecha_propuesta" type="text" class="datepicker">
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3">
                <label for="fecha_resolucion">Fecha de resolución</label>
                <input name="fecha_resolucion" id="fecha_resolucion" type="text" class="datepicker">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="costo_estimado" name="costo_estimado" type="text" class="validate">
                <label for="costo_estimado">Costo estimado</label>
            </div>
            <div class="input-field col s12 m3">
                <input id="costo_real" name="costo_real" type="text" class="validate">
                <label for="costo_real">Costo real</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="resultado" name="resultado" type="text" class="validate">
                <label for="resultado">Resultado</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <textarea id="observaciones" name="observaciones" class="materialize-textarea"></textarea>
                <label for="observaciones">Observaciones</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="estatus" name="estatus" type="text" class="validate">
                <label for="estatus">Estatus</label>
            </div>
        </div>


        
    </form>
</div>

@endsection


