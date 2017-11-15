@extends('layout.app')

@section('title')
    Jóvenes
@endsection

@section('head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script> 
    <script type="text/javascript" src="{{url('/js/joven/nuevo.js')}}"></script>
@endsection

@section('cabecera')
    Jóvenes
@endsection


@section('contenedor')
  <div class="row">
    <h4>Nuevo Registro</h4>
  </div>
  <div class="row" id="nuevo-registro">
    @foreach($errors->all() as $error)
      <div class="red-text">{{$error}}</div>
    @endforeach
    <form id="form-nj" method="post" action="{{url('/jovenes/registrar')}}" class="col s12" enctype="multipart/form-data">
      <div id="DUsuario" class="col s12">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="row" id="cntr">
            <div class="col s12">
              <img id="image" class="circle" src="{{url('/img/jovenes/default-user-image.png')}}" height="180" width="180"></img>
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
                <input id="email" name="email" type="email" class="validate">
                <label for="email">Correo electrónico</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m3">
                <input id="password" name="password" type="password" class="validate">
                <label for="password">Contraseña</label>
              </div>
              <div class="input-field col s12 m3">
                <input id="confirmar_password" name="confirmar_password" type="password" class="validate">
                <label for="confirmar_password">Confirmar contraseña</label>
              </div>
            </div>
            
            <div class="row" id="cntr">
              <div class="input-field col s12 m6">
                <input id="curp" name="curp" type="text" class="validate">
                <label for="curp">CURP</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input field col s12 m6">
                <a href="https://consultas.curp.gob.mx/CurpSP/inicio2_2.jsp">¿No conoces tu CURP?, ¡Consúltalo aquí!</a>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m6">
                <input id="nombre" name="nombre" type="text" class="validate" readonly>
                <label class="label-curp" for="nombre">Nombre(s)</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m3">
                <input id="apellido_paterno" name="apellido_paterno" type="text" class="validate" readonly>
                <label class="label-curp" for="apellido_paterno">Apellido Paterno</label>
              </div>
              <div class="input-field col s12 m3">
                <input id="apellido_materno" name="apellido_materno" type="text" class="validate" readonly>
                <label class="label-curp" for="apellido_materno">Apellido Materno</label>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="input-field col s12 m3">
                <input id="fecha_nacimiento" name="fecha_nacimiento" type="text" class="validate" readonly>
                <label class="label-curp" for="fecha_nacimiento">Fecha de Nacimiento</label>
              </div>
              <div class="col s12 m3">
                <label class="label-curp">Género</label>
                <select class="browser-default" id="id_genero" name="genero" readonly>
                @foreach($generos as $genero)
                  <option value="{{$genero->abreviatura}}">{{$genero->nombre}}</option>
                @endforeach
                </select>
              </div>
            </div>
            <div class="row" id="cntr">
              <div class="col s12 m3">
                <label class="label-curp">Estado de Nacimiento</label>
                <select class="browser-default" id="id_estado_nacimiento" name="estado_nacimiento" readonly>
                @foreach($estados as $estado)
                  <option value="{{$estado->abreviatura}}">{{$estado->nombre}}</option>
                @endforeach
                </select>
              </div>
              <div class="input-field col s12 m3">
                <input id="codigo_postal" name="codigo_postal" type="text" class="validate">
                <label for="codigo_postal">Código Postal</label>
              </div>
            </div>
            <div class="col s12 m3" style="padding-top: 100px;">
              <i class="waves-effect waves-light btn waves-input-wrapper">
              <input type="submit" class="waves-button-input" value="Registrar">
              </i>
            </div>
          </div>
        </div>
      </div>
    </div>  
    </form> 
  </div>    
</div>
@endsection
