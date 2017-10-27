@extends('layout.app')

@section('title')
    Jóvenes
@endsection

@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script> 
    <script type="text/javascript" src="{{url('/js/joven/perfil.js')}}"></script>
@endsection

@section('cabecera')
    Jóvenes
@endsection


@section('contenedor')
    <div class="row">
        <h4>Perfil de Joven</h4>
    </div>
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-perfil" method="post" action="{{url('/jovenes/perfil')}}" class="col s12" enctype="multipart/form-data">
            <input type="hidden" name="idUsuario" value="{{$usuario->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                <div class="col s12 m8 offset-m2 l6 offset-l3">
        <div class="card-panel grey lighten-5 z-depth-1">
          <div class="row valign-wrapper">
            <div class="col s2">
              <img src="{{url('/img/jovenes/default-user-image.png')}}" alt="" class="circle responsive-img">
            </div>
            <div class="col s10">
              <span class="black-text">
                <p>{{$codigoGuanajoven->id_codigo_guanajoven}}</p>
                <p>{{$datosUsuario->curp}}</p>
                <p>{{$datosUsuario->nombre}} {{$datosUsuario->apellido_paterno}} {{$datosUsuario->apellido_materno}}</p>
                <p>{{$usuario->email}}</p>
              </span>
            </div>
          </div>
        </div>
      </div>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="row">
                    <div class="col s5">
                        <label>Estado</label>
                        <select class="browser-default" id="id_estado" name="id_estado">
                        @foreach($estados as $estado)
                            <option value="{{$estado->id_estado}}" {{$datosUsuario->id_estado == $estado->id_estado ? 'selected' : ''}}>{{$estado->nombre}}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                <div class="col s5">
                    <label>Municipio</label>
                    <select class="browser-default" name="id_municipio" id="id_municipio">
                        @foreach($municipios as $municipio)
                            <option value="{{$municipio->id_municipio}}" {{$datosUsuario->id_municipio == $municipio->id_municipio ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                        @endforeach    
                    </select>
                </div>
                </div>
                <div class="row">
                <div class="col s5">
                    <label>Último nivel de estudios</label>
                    <select class="browser-default" name="id_nivel_estudios" id="id_nivel_estudios">
                        @foreach($niveles_estudio as $nivel_estudio)
                            <option value="{{$nivel_estudio->id_nivel_estudios}}" {{$datosUsuario->id_nivel_estudios == $nivel_estudio->id_nivel_estudios ? 'selected' : ''}}>{{$nivel_estudio->nombre}}</option>
                        @endforeach    
                    </select>
                </div>
                </div>
                <div class="row">
                <div class="col s5">
                        <label>¿Eres beneficiario de algún programa de gobierno?</label>
                        <select class="browser-default" id="programa" name="programa">
                            <option value="" {{isset($datosUsuario->id_programa_beneficiario)  ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->id_programa_beneficiario)  ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="col s5" id="tipo-programa" style="display: {{isset($datosUsuario->id_pueblo_indigena)  ? 'block' : 'none'}}">
                        <label>¿De qué tipo?</label>
                        <select class="browser-default" name="id_programa_beneficiario" id="id_programa_beneficiario">
                            <option value="">Selecciona</option>
                            @foreach($programas_gobierno as $programa_gobierno)
                                <option value="{{$programa_gobierno->id_programa_gobierno}}" {{$datosUsuario->id_programa_beneficiario == $programa_gobierno->id_programa_gobierno ? 'selected' : ''}}>{{$programa_gobierno->nombre}}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
                <div class="row">
                <div class="col s5">
                        <label>¿Trabajas?</label>
                        <select class="browser-default" id="trabaja" name="trabaja">
                            <option value="0" {{$datosUsuario->trabaja == 0 ? 'selected' : ''}}>No</option>
                            <option value="1" {{$datosUsuario->trabaja == 1 ? 'selected' : ''}}>Sí</option>
                        </select>
                    </div>
                    </div>
                    <div class="row">
                <div class="col s5">
                    <label>¿Eres originario de algún pueblo o comunidad indígena?</label>
                    <select class="browser-default" name="pueblo" id="pueblo">
                    <option value="0" {{isset($datosUsuario->id_pueblo_indigena)  ? "" : 'selected'}}>No</option>
                    <option value="1" {{isset($datosUsuario->id_pueblo_indigena)  ? 'selected' : ""}}>Sí</option>
                    </select>
                </div>
                <div class="col s5" id="tipo-pueblo" style="display: {{isset($datosUsuario->id_pueblo_indigena)  ? 'block' : 'none'}}">
                    <label>¿De cuál?</label>
                    <select class="browser-default" name="id_pueblo_indigena" id="id_pueblo_indigena">
                        <option value="">Selecciona</option>
                        @foreach ($pueblos_indigena as $pueblo_indigena)
                            <option value="{{$pueblo_indigena->id_pueblo_indigena}}" {{$datosUsuario->id_pueblo_indigena == $pueblo_indigena->id_pueblo_indigena ? 'selected' : ''}}>{{$pueblo_indigena->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="row">
                <div class="col s5">
                    <label>¿Presentas alguna capacidad diferente?</label>
                    <select class="browser-default" name="capacidad" id="capacidad">
                        <option value="0" {{isset($datosUsuario->id_capacidad_diferente) ? "" : 'selected'}}>No</option>
                        <option value="1" {{isset($datosUsuario->id_capacidad_diferente) ? 'selected' : ""}}>Sí</option>
                    </select>
                </div>
                <div class="col s5" id="tipo-capacidad" style="display: {{isset($datosUsuario->id_capacidad_diferente)  ? 'block' : 'none'}}">
                    <label>¿De qué tipo?</label>
                    <select class="browser-default" name="id_capacidad_diferente" id="id_capacidad_diferente">
                        <option value="">Selecciona</option>
                        @foreach ($capacidades_diferente as $capacidad_diferente)
                            <option value="{{$capacidad_diferente->id_capacidad_diferente}}" {{$datosUsuario->id_capacidad_diferente == $capacidad_diferente->id_capacidad_diferente ? 'selected' : ''}}>{{$capacidad_diferente->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                </div>
                <div class="row">
                <div class="col s5">
                    <label>¿Has obtenido premios o distinciones?</label>
                    <select class="browser-default" name="premio" id="premio">
                    <option value="" {{isset($datosUsuario->premios) ? "" : 'selected'}}>No</option>
                    <option value="1" {{isset($datosUsuario->premios) ? 'selected' : ""}}>Sí</option>
                    </select>
                </div>
                    <div class="input-field col s5" id="tipo-premios" style="display: {{isset($datosUsuario->premios)  ? 'block' : 'none'}}">
                        <input id="premios" name="premios" type="text" class="validate" value="{{$datosUsuario->premios}}">
                        <label for="premios">Menciona cuál(es)</label>
                    </div>
                    </div>
                    <div class="row">
                    <div class="col s5">
                    <label>¿Participas en algún proyecto social que beneficie a tu comunidad?</label>
                    <select class="browser-default" name="proyecto" id="proyecto">
                    <option value="" {{isset($datosUsuario->proyectos_sociales) ? "" : 'selected'}}>No</option>
                    <option value="1" {{isset($datosUsuario->proyectos_sociales) ? 'selected' : ""}}>Sí</option>
                    </select>
                </div>
                    <div class="input-field col s5" id="proyectos" style="display: {{isset($datosUsuario->proyectos_sociales)  ? 'block' : 'none'}}">
                        <input id="proyectos_sociales" name="proyectos_sociales" type="text" class="validate" value="{{$datosUsuario->proyectos_sociales}}">
                        <label for="proyectos_sociales">Menciona cuál(es)</label>
                    </div>
                    <div class="col s5" id="economico" style="display: {{isset($datosUsuario->apoyo_proyectos_sociales)  ? 'block' : 'none'}}">
                        <label>¿Recibes sueldo o apoyo económico por esto?</label>
                        <select class="browser-default" id="apoyo_proyectos_sociales" name="apoyo_proyectos_sociales">
                            <option value="0"{{$datosUsuario->apoyo_proyectos_sociales == 0 ? 'selected' : ''}}>No</option>
                            <option value="1"{{$datosUsuario->apoyo_proyectos_sociales == 1 ? 'selected' : ''}}>Sí</option>
                        </select>
                    </div>
                    </div>
                    <!--<div id="Documentos" class="col s6">
                        <div class="file-field input-field col s8">
                            <div class="btn" style="background: #BF3364;">
                                <span>Documentos</span>
                                <input type="file" multiple>
                            </div>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" placeholder="Cargar documentos">
                        </div>
                    </div>-->
                    <div class="col s3 offset-s5" style="padding-top: 100px;">
                        <i class="waves-effect waves-light btn waves-input-wrapper">
                        <input type="submit" class="waves-button-input" value="Actualizar">
                        </i>
                    </div>
        <!--  <div class="input-field col s3 offset-s5">
            <a class="waves-effect waves-light btn" id="btnSiguiente2">Siguiente ></a>
          </div>
          <div class="input-field col s3 offset-s5">
            <a class="waves-effect waves-light btn" id="btnAnterior">< Anterior </a>
          </div>
      </div>
         <div class="input-field col s3 offset-s7">
              <a class="waves-effect waves-light btn" id="btnAnterior2">< Anterior </a>
          </div>-->
            </div>
        </div>
    </div>
</form> 
  </div>    
</div>
@endsection
