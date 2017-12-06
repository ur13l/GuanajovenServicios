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
                <input id="id_orden_atencion" name="id_orden_atencion" type="text" class="validate" value="{{$ordenes_atencion->id_orden_atencion}}">
                <label for="id_orden_atencion">Id. Orden</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <select id="id_region" class="select-wrapper validate" name="id_region">
                    @foreach ($regiones as $region)
                        <option value="{{$region->id_region}}" {{$ordenes_atencion->id_region == $region->id_region ? 'selected' : ''}}>{{$region->id_region}}</option>
                    @endforeach
                </select>
                <label>Región responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <select id="id_centro_poder_joven" class="select-wrapper validate" name="id_centro_poder_joven">
                    @foreach($centros as $centro) 
                        <option value="{{$centro->id_centro_poder_joven}}" {{$ordenes_atencion->id_centro_poder_joven == $centro->id_centro_poder_joven ? 'selected' : ''}}>{{$centro->nombre}}</option>
                    @endforeach
                </select>
                <label for="id_centro_poder_joven">Centro Poder Joven</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <select id="id_area" class="select-wrapper validate" name="id_area">
                    @foreach($areas as $area) 
                        <option value="{{$area->id}}" {{$ordenes_atencion->id_area == $area->id ? 'selected' : ''}}>{{$area->nombre}}</option>
                    @endforeach
                </select>
                <label for="id_area">Área responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <div class="autocomplete" id="usuario_responsable">
                    <div class="ac-input">
                        <input type="text" id="id_usuario_responsable_autocomplete"  placeholder="" data-activates="usuarioResponsableDropdown" data-beloworigin="true" autocomplete="off" value="{{$ordenes_atencion->id_usuario_responsable}}">
                        <input type="hidden" id="id_usuario_responsable"  name="id_usuario_responsable" placeholder="Please input some letters"  data-activates="usuarioResponsableDropdown" data-beloworigin="true" autocomplete="off">
                    </div>
                    <ul id="usuarioResponsableDropdown" class="dropdown-content ac-dropdown"></ul>
                </div>
                <label class="active" for="id_usuario_responsable_autocomplete">Usuario responsable: </label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <div class="autocomplete" id="multiple">
                    <div class="ac-users ac-appender"></div>
                        <div class="ac-input">
                            <input type="text" id="usuarios_involucrados"  data-activates="multipleDropdown" data-beloworigin="true" class="validate" autocomplete="off" value="{{$ordenes_atencion->id_usuario_responsable}}">
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
        <select id="id_servicio" class="select-wrapper validate" name="id_servicio">
            @foreach($servicios as $servicio) 
                <option value="{{$servicio->id_servicio}}" {{$ordenes_atencion->servicios->first()->id_servicio == $servicio->id_servicio ? 'selected' : '' }}>{{$servicio->titulo}}</option>
            @endforeach
        </select>
        <label for="id_servicio">Servicio </label>
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
                <input id="titulo" name="titulo" type="text" class="validate" value="{{$ordenes_atencion->titulo}}">
                <label for="titulo">Título de orden de servicio</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <textarea id="descripcion" name="descripcion" class="materialize-textarea" >{{$ordenes_atencion->descripcion}}</textarea>
                <label for="descripcion">Descripción de orden de servicio</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3">
                <label for="fecha_inicio">Fecha de inicio</label>
                <input name="fecha_inicio" id="fecha_inicio" type="text" class="datepicker" value="{{$ordenes_atencion->fecha_inicio}}">
            </div>
            <div class="col s12 m3">
                <label for="fecha_propuesta">Fecha propuesta</label>
                <input name="fecha_propuesta" id="fecha_propuesta" type="text" class="datepicker" value="{{$ordenes_atencion->fecha_propuesta}}">
            </div>
        </div>
        <div class="row">
            <div class="col s12 m3">
                <label for="fecha_resolucion">Fecha de resolución</label>
                <input name="fecha_resolucion" id="fecha_resolucion" type="text" class="datepicker" value="{{$ordenes_atencion->fecha_resolucion}}">
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <input id="costo_estimado" name="costo_estimado" type="text" class="validate" value="{{$ordenes_atencion->costo_estimado}}">
                <label for="costo_estimado">Costo estimado</label>
            </div>
            <div class="input-field col s12 m3">
                <input id="costo_real" name="costo_real" type="text" class="validate" value="{{$ordenes_atencion->costo_real}}">
                <label for="costo_real">Costo real</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">    
                <input id="resultado" name="resultado" type="text" class="validate" value="{{$ordenes_atencion->resultado}}">
                <label for="resultado">Resultado</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <textarea id="observaciones" name="observaciones" class="materialize-textarea">{{$ordenes_atencion->observaciones}}</textarea>
                <label for="observaciones">Observaciones</label>
            </div>
        </div>
        <div class="input-field col s12 m3">
            <select id="id_estatus" class="select-wrapper validate" name="id_estatus">
                @foreach($estatus_orden as $estatus) 
                    <option value="{{$estatus->id}}" {{$ordenes_atencion->id_estatus == $estatus->id ? 'selected' : ''}}>{{$estatus->nombre}}</option>
                @endforeach
            </select>
            <label for="id_estatus">Estatus</label>
        </div>
        <div class="divider"></div>
            <div class="section" id="doc-container">
                <h5>Documentos</h5>
                <div class="section hoverable">
                    <input type="hidden" name="doc-id[]">
                    <div class="row">
                        <div class="col m2 hide-on-small-and-down">
                            <span class="col l12 center-align">
                                    
                            </span>
                        </div>
                        <div class="input-field col s5 l6">
                            <input id="doc-titulo[]" name="doc-titulo[]" type="text" class="validate">
                            <label for="titulo">Título</label>
                        </div>
                        <div class="file-field input-field col s5 m3 l2 ">
                            <div class="btn accent-color">
                                <span>Cambiar </span>
                                <input type="file" class="input-doc-file"  >
                            </div>
                        </div>
                        <div class="col s2">
                            <p class="col s12 center-align">
                                <a class="large center center-align delete-doc grey-text" style="margin-top:30px; cursor: pointer" ><i class="material-icons">delete</i></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s1 offset-s5">
                    <a class="btn-floating center waves-effect waves-light  center-align accent-color right" id="agregar-documento"><i class="material-icons">add</i></a>
                </div>
            </div>
                        
        
    </form>
</div>

@endsection


