@extends('layout.app')

@section('title')
    Servicios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/servicio/nuevo.js')}}"></script> 
     <style>
        .autocomplete {
            display: -ms-flexbox;
            display: flex;
        }
        .autocomplete .ac-users {
            padding-top: 10px;
        }
        .autocomplete .ac-users .chip {
            -ms-flex: auto;
            flex: auto;
            margin-bottom: 10px;
            margin-right: 10px;
        }
        .autocomplete .ac-users .chip:last-child {
            margin-right: 5px;
        }
        .autocomplete .ac-dropdown .ac-hover {
            background: #eee;
        }
        .autocomplete .ac-input {
            -ms-flex: 1;
            flex: 1;
            min-width: 150px;
            padding-top: 0.6rem;
        }
        .autocomplete .ac-input input {
            height: 2.4rem;
        }
    </style>
@endsection

@section('cabecera')
    Servicios
@endsection

@section('contenedor')
<div class="row">
    <h4>Nueva orden de servicio</h4>
</div>
<div class="row">
    @foreach($errors->all() as $error)
      <div class="red-text">{{$error}}</div>
    @endforeach
    <form id="form-ns" method="post" action="{{url('/servicio/registrar')}}" class="col s12" enctype="multipart/form-data">
        <!--Editar nombres según BD -->
      
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="titulo" name="tíiulo" type="text" class="validate">
                <label for="titulo">Título</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <textarea id="descripcion" name="descripcion" class="materialize-textarea"></textarea>
                <label for="descripcion">Descripción</label>
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
            <div class="input-field col s12 m3">
                <input id="costo_estimado" name="costo_estimado" type="text" class="validate">
                <label for="costo_estimado">Costo estimado</label>
            </div>
            <div class="input-field col s12 m3">
                <select id="id_estatus" class="select-wrapper validate" name="id_estatus">
                    @foreach($estatus_orden as $estatus) 
                        <option value="{{$estatus->id_estatus}}">{{$estatus->nombre}}</option>
                    @endforeach
                </select>
                <label for="id_estatus">Estatus</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m3">
                <select id="id_region" class="select-wrapper validate" name="id_region">
                    @foreach($regiones as $region) 
                        <option value="{{$region->id}}">{{$region->nombre}}</option>
                    @endforeach
                </select>
                <label>Región responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <select id="id_centro_poder_joven" class="select-wrapper validate" name="id_centro_poder_joven">
                    @foreach($centros as $centro) 
                        <option value="{{$centro->id_centro_poder_joven}}">{{$centro->nombre}}</option>
                    @endforeach
                </select>
                <label for="id_centro_poder_joven">Centro Poder Joven</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m3">
                <select id="id_area" class="select-wrapper validate" name="id_area">
                    @foreach($areas as $area) 
                        <option value="{{$area->id_area}}">{{$area->nombre}}</option>
                    @endforeach
                </select>
                <label for="id_area">Área responsable</label>
            </div>
            <div class="input-field col s12 m3">
                <div class="autocomplete" id="usuario_responsable">
                        <div class="ac-input">
                            <input type="text" id="id_usuario_responsable_autocomplete"  placeholder="Please input some letters" data-activates="usuarioResponsableDropdown" data-beloworigin="true" autocomplete="off">
                            <input type="hidden" id="id_usuario_responsable"  name="id_usuario_responsable" placeholder="Please input some letters" data-activates="usuarioResponsableDropdown" data-beloworigin="true" autocomplete="off">
                        </div>
                        <ul id="usuarioResponsableDropdown" class="dropdown-content ac-dropdown"></ul>
                </div>
                <label class="active" for="id_usuario_responsable_autocomplete">Usuario responsable: </label>
            </div>
        </div>
        <div class="row">
             <div class="input-field col s12 ">
                <div class="autocomplete" id="usuarios_involucrados">
                        <div class="ac-input">
                            <div class="ac-users"></div>
                            <input type="text" id="id_usuarios_involucrados_autocomplete"  placeholder="Please input some letters" data-activates="usuariosInvolucradosDropdown" data-beloworigin="true" autocomplete="off">
                        </div>
                        <ul id="usuariosInvolucradosDropdown" class="dropdown-content ac-dropdown"></ul>
                        <input type="hidden" id="id_usuarios_involucrados"  name="id_usuarios_involucrados">

                </div>
                <label class="active" for="id_usuarios_involucrados_autocomplete">Usuarios involucrados: </label>
            </div>
        </div>
        <div class="row">
           <div class="input-field col s12 m3">
                <div class="autocomplete" id="joven_responsable">
                        <div class="ac-input">
                            <input type="text" id="id_joven_responsable_autocomplete"  placeholder="Please input some letters" data-activates="jovenResponsableDropdown" data-beloworigin="true" autocomplete="off">
                            <input type="hidden" id="id_joven_responsable"  name="id_joven_responsable" data-activates="jovenResponsableDropdown" data-beloworigin="true" autocomplete="off">
                        </div>
                        <ul id="jovenResponsableDropdown" class="dropdown-content ac-dropdown"></ul>
                </div>
                <label class="active" for="id_joven_responsable_autocomplete">Joven beneficiado: </label>
            </div>
            <div class="input-field col s12 m3">
                <select id="id_tipo_servicio" class="select-wrapper validate" name="id_tipo_servicio">
                    @foreach($servicios as $servicio) 
                        <option value="{{$servicio->id_servicio}}">{{$servicio->titulo}}</option>
                    @endforeach
                </select>
                <label for="id_tipo_servicio">Servicio </label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="beneficiados_relacionados" name="beneficiados_relacionados" type="text" class="validate">
                <label for="beneficiados_relacionados">Jóvenes beneficiados </label>
            </div>
        </div>
        


        
    </form>
</div>

@endsection


