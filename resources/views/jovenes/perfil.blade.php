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
    <form id="form-perfil" method="post" action="{{url('/jovenes/perfil')}}" class="col s12" enctype="multipart/form-data">
    <div class="row row-general">
        @foreach($errors->all() as $error)
        <div class="red-text">{{$error}}
        </div>
        @endforeach
            <input type="hidden" name="idUsuario" value="{{$usuario->id}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row" id="cntr">
            <div class="col s12">
              <img id="image" class="circle" src="{{$datosUsuario->ruta_imagen}}" height="180" width="180"></img>
            </div>
            <div class="row " id="cntr">
              <div class="input-field col s12 m6">
                <div class="file-field input-field col s12 m7">
                  <div class="btn" style="background: #BF3364;">
                    <span center-align>Imagen</span>
                    <input type="file" id="ruta_imagen" name="ruta_imagen" onchange="readURL(this)">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Agrega una imagen">
                  </div>
                </div>
              </div>
            </div>
          </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m6">
                <input id="curp" name="curp" type="text" class="validate" value="{{$datosUsuario->curp}}" readonly>
                <label for="curp">CURP</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m6">
                <input id="nombre" name="nombre" type="text" class="validate" value="{{$datosUsuario->nombre}}"readonly>
                <label class="label-curp" for="nombre">Nombre(s)</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m3">
                <input id="apellido_paterno" name="apellido_paterno" type="text" class="validate" value="{{$datosUsuario->apellido_paterno}}" readonly>
                <label class="label-curp" for="apellido_paterno">Apellido Paterno</label>
              </div>
              <div class="input-field col s12 m3">
                <input id="apellido_materno" name="apellido_materno" type="text" class="validate" value="{{$datosUsuario->apellido_materno}}" readonly>
                <label class="label-curp" for="apellido_materno">Apellido Materno</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="col s12 m3">
                <label class="label-curp">Género</label>
                <select class="browser-default" id="id_genero" name="genero" disabled>
                @foreach($generos as $genero)
                  <option value="{{$genero->abreviatura}}">{{$datosUsuario->genero->nombre}}</option>
                @endforeach
                </select>
              </div>
              <div class="col s12 m3">
                <label class="label-curp">Estado de Nacimiento</label>
                <select class="browser-default" id="id_estado_nacimiento" name="estado_nacimiento" disabled>
                @foreach($estados as $estado)
                  <option value="{{$estado->abreviatura}}">{{$datosUsuario->estado->nombre}}</option>
                @endforeach
                </select>
              </div>
            </div>
            <br><br>
            <div class="divider"></div>
            <br><br>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row" id="cntr">
              <div class="input-field col s12 m3">
                <input id="email" name="email" type="email" class="validate" value="{{$usuario->email}}">
                <label for="email">Correo electrónico</label>
              </div>
              <div class="input-field col s12 m3">
                <input id="codigo_postal" name="codigo_postal" type="text" class="validate" value="{{$datosUsuario->codigo_postal}}">
                <label for="codigo_postal">Código Postal</label>
              </div>
            </div>
                <div class="row">
                    <div class="col s12 m3">
                        <label>Estado donde radica</label>
                        <select class="browser-default" id="id_estado" name="id_estado" disabled>
                            @foreach($estados as $estado)
                            <option value="{{$estado->id_estado}}" {{$datosUsuario->id_estado == $estado->id_estado ? 'selected' : ''}}>{{$estado->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col s12 m3">
                        <label>Municipio donde radica</label>
                        <select class="browser-default" name="id_municipio" id="id_municipio" disabled>
                            @foreach($municipios as $municipio)
                                <option value="{{$municipio->id_municipio}}" {{$datosUsuario->id_municipio == $municipio->id_municipio ? 'selected' : ''}}>{{$municipio->nombre}}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3">
                        <label>Último nivel de estudios</label>
                        <select class="browser-default" name="id_nivel_estudios" id="id_nivel_estudios">
                            @foreach($niveles_estudio as $nivel_estudio)
                                <option value="{{$nivel_estudio->id_nivel_estudios}}" {{$datosUsuario->id_nivel_estudios == $nivel_estudio->id_nivel_estudios ? 'selected' : ''}}>{{$nivel_estudio->nombre}}</option>
                            @endforeach    
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3">
                        <label>¿Eres beneficiario de algún programa de gobierno?</label>
                        <select class="browser-default" id="programa" name="programa">
                            <option value="" {{isset($datosUsuario->id_programa_beneficiario)  ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->id_programa_beneficiario)  ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="col s12 m3" id="tipo-programa" style="display: {{isset($datosUsuario->id_pueblo_indigena)  ? 'block' : 'none'}}">
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
                    <div class="col s12 m3">
                        <label>¿Trabajas?</label>
                        <select class="browser-default" id="trabaja" name="trabaja">
                            <option value="0" {{$datosUsuario->trabaja == 0 ? 'selected' : ''}}>No</option>
                            <option value="1" {{$datosUsuario->trabaja == 1 ? 'selected' : ''}}>Sí</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3">
                        <label>¿Eres originario de algún pueblo o comunidad indígena?</label>
                        <select class="browser-default" name="pueblo" id="pueblo">
                            <option value="0" {{isset($datosUsuario->id_pueblo_indigena)  ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->id_pueblo_indigena)  ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="col s12 m3" id="tipo-pueblo" style="display: {{isset($datosUsuario->id_pueblo_indigena)  ? 'block' : 'none'}}">
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
                    <div class="col s12 m3">
                        <label>¿Presentas alguna capacidad diferente?</label>
                        <select class="browser-default" name="capacidad" id="capacidad">
                            <option value="0" {{isset($datosUsuario->id_capacidad_diferente) ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->id_capacidad_diferente) ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="col s12 m3" id="tipo-capacidad" style="display: {{isset($datosUsuario->id_capacidad_diferente)  ? 'block' : 'none'}}">
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
                    <div class="col s12 m3">
                        <label>¿Has obtenido premios o distinciones?</label>
                        <select class="browser-default" name="premio" id="premio">
                            <option value="" {{isset($datosUsuario->premios) ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->premios) ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m3" id="tipo-premios" style="display: {{isset($datosUsuario->premios)  ? 'block' : 'none'}}">
                        <input id="premios" name="premios" type="text" class="validate" value="{{$datosUsuario->premios}}">
                        <label for="premios">Menciona cuál(es)</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m3">
                        <label>¿Participas en algún proyecto social que beneficie a tu comunidad?</label>
                        <select class="browser-default" name="proyecto" id="proyecto">
                            <option value="" {{isset($datosUsuario->proyectos_sociales) ? "" : 'selected'}}>No</option>
                            <option value="1" {{isset($datosUsuario->proyectos_sociales) ? 'selected' : ""}}>Sí</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m3" id="proyectos" style="display: {{isset($datosUsuario->proyectos_sociales)  ? 'block' : 'none'}}">
                        <input id="proyectos_sociales" name="proyectos_sociales" type="text" class="validate" value="{{$datosUsuario->proyectos_sociales}}">
                        <label for="proyectos_sociales">Menciona cuál(es)</label>
                    </div>
                    <div class="col s12 m3" id="economico" style="display: {{isset($datosUsuario->apoyo_proyectos_sociales)  ? 'block' : 'none'}}">
                        <label>¿Recibes sueldo o apoyo económico por esto?</label>
                        <select class="browser-default" id="apoyo_proyectos_sociales" name="apoyo_proyectos_sociales">
                            <option value="0"{{$datosUsuario->apoyo_proyectos_sociales == 0 ? 'selected' : ''}}>No</option>
                            <option value="1"{{$datosUsuario->apoyo_proyectos_sociales == 1 ? 'selected' : ''}}>Sí</option>
                        </select>
                    </div>
                </div>
                <br>
                <h5>Idioma(s)</h5> <a class="btn-floating idiomabtn"><i class="material-icons">add</i></a> 
                <br>
                <br>
                @if (count($datosUsuario->idiomasAdicionales) > 0)
                    @foreach($datosUsuario->idiomasAdicionales as $idiomaAdicional)
                    <div class="row row-idioma">  
                        <div class="col s2">
                            <select class="browser-default" name="idioma[]" id="idioma">
                                <option value="">Selecciona</option>
                                @foreach($idiomas as $idioma)
                                <option value="{{$idioma->id_idioma_adicional}}" {{$idiomaAdicional->id_idioma_adicional == $idioma->id_idioma_adicional ? 'selected' : ''}}>{{$idioma->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s2" id="conversacion">
                            <input id="conversacion" name="conversacion[]" type="number" min="0" max="100" class="validate"  value="{{$idiomaAdicional->pivot->conversacion}}">
                            <label for="conversacion">Conversación</label>
                        </div>
                        <div class="input-field col s2" id="lectura">
                            <input id="lectura" name="lectura[]" type="number" min="0" max="100" class="validate" value="{{$idiomaAdicional->pivot->lectura}}">
                            <label for="lectura">Lectura</label>
                        </div>
                        <div class="input-field col s2" id="escritura">
                            <input id="escritura" name="escritura[]" type="number" min="0" max="100" class="validate" value="{{$idiomaAdicional->pivot->escritura}}">
                            <label for="escritura">Escritura</label>
                        </div> 
                        <i class="material-icons grey-text borrar-idioma" style="cursor: pointer">delete</i>   
                    </div>
                    @endforeach
                @else
                <div class="row row-idioma">  
                    <div class="col s2">
                        <select class="browser-default" name="idioma[]" id="idioma">
                            <option value="">Selecciona</option>
                            @foreach($idiomas as $idioma)
                            <option value="{{$idioma->id_idioma_adicional}}">{{$idioma->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-field col s2" id="conversacion">
                        <input id="conversacion" name="conversacion[]" type="number" min="0" max="100" class="validate">
                        <label for="conversacion">Conversación</label>
                    </div>
                    <div class="input-field col s2" id="lectura">
                        <input id="lectura" name="lectura[]" type="number" min="0" max="100" class="validate">
                        <label for="lectura">Lectura</label>
                    </div>
                    <div class="input-field col s2" id="escritura">
                        <input id="escritura" name="escritura[]" type="number" min="0" max="100" class="validate">
                        <label for="escritura">Escritura</label>
                    </div> 
                    <i class="material-icons grey-text borrar-idioma" style="cursor: pointer">delete</i>   
                </div>
                @endif              
        </div>
        <div class="row">
            <div class="col s3 offset-s5" style="padding-top: 100px;">
                <i class="waves-effect waves-light btn waves-input-wrapper">
                    <input type="submit" class="waves-button-input" value="Actualizar">
                </i>
            </div>
        </div>
        </form>
@endsection
