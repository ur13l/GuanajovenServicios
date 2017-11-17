@extends('layout.app')

@section('title')
    Jóvenes
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/joven/crear.js')}}"></script>
@endsection

@section('cabecera')
    Jóvenes
@endsection


@section('contenedor')
    <div class="row">
        <h4>Editar Joven</h4>
    </div>
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-nj" method="post" action="{{url('/jovenes/editar')}}" class="col s12" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <!--{{csrf_field()}}-->
            <div class="row">
                <div class="input-field col s8">
                    <input id="nombre" name="nombre" type="text" class="validate">
                    <label for="nombre">Nombre(s)</label>
                </div>
                <div class="input-field col s8">
                    <input id="apellido_paterno" name="apellido_paterno" type="text" class="validate">
                    <label for="apellido_paterno">Apellido Paterno</label>
                </div>
                <div class="input-field col s8">
                    <input id="apellido_materno" name="apellido_materno" type="text" class="validate">
                    <label for="apellido_materno">Apellido Materno</label>
                </div>
                <div class="col s5">
                  <label>Género</label>
                  <select class="browser-default" id="id_genero" name="id_genero" >
                    <option value="1" selected>Masculino</option>
                    <option value="2">Femenino</option>
                  </select>
                </div>
                <div class="input-field col s8 m6">
                    <input id="fecha_nacimiento" name="fecha_nacimiento" class="datepicker">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                </div>
                <div class="col s5">
                  <label>Estado de Nacimiento</label>
                  <select class="browser-default" id="id_estado_nacimiento" name="id_estado_nacimiento" >
                    <option value="1" selected>Aguascalientes</option>
                    <option value="2">Baja California</option>
                    <option value="3">Baja California Sur</option>
                    <option value="4">Campeche</option>
                    <option value="5">Chiapas</option>
                    <option value="6">Chihuahua</option>
                    <option value="7">Coahuila</option>
                    <option value="8">Colima</option>
                    <option value="9">Ciudad de México</option>
                    <option value="10">Durango</option>
                    <option value="11">México</option>
                    <option value="12">Guanajuato</option>
                    <option value="13">Guerrero</option>
                    <option value="14">Hidalgo</option>
                    <option value="15">Jalisco</option>
                    <option value="16">Michoacán</option>
                    <option value="17">Morelos</option>
                    <option value="18">Nayarit</option>
                    <option value="19">Nuevo León</option>
                    <option value="20">Oaxaca</option>
                    <option value="21">Puebla</option>
                    <option value="22">Querétaro</option>
                    <option value="23">Quintana Roo</option>
                    <option value="24">San Luis Potosí</option>
                    <option value="25">Sinaloa</option>
                  </select>
                </div>
                <div class="input-field col s8">
                    <input id="email" name="email" type="email" class="validate">
                    <label for="email">Correo electrónico</label>
                </div>
                <div class="input-field col s8">
                    <input id="codigo_postal" name="codigo_postal" type="text" class="validate">
                    <label for="codigo_postal">Código Postal</label>
                </div>
                <div class="input-field col s8">
                    <input id="telefono" name="telefono" type="text" class="validate">
                    <label for="telefono">Teléfono</label>
                </div>
                <div class="input-field col s8">
                    <input id="curp" name="curp" type="text" class="validate">
                    <label for="curp">CURP</label>
                </div>
                <div class="col s5">
                  <label>Estado</label>
                  <select class="browser-default" id="id_estado" name="id_estado" >
                    <option value="1" selected>Aguascalientes</option>
                    <option value="2">Baja California</option>
                    <option value="3">Baja California Sur</option>
                    <option value="4">Campeche</option>
                    <option value="5">Chiapas</option>
                    <option value="6">Chihuahua</option>
                    <option value="7">Coahuila</option>
                    <option value="8">Colima</option>
                    <option value="9">Ciudad de México</option>
                    <option value="10">Durango</option>
                    <option value="11">México</option>
                    <option value="12">Guanajuato</option>
                    <option value="13">Guerrero</option>
                    <option value="14">Hidalgo</option>
                    <option value="15">Jalisco</option>
                    <option value="16">Michoacán</option>
                    <option value="17">Morelos</option>
                    <option value="18">Nayarit</option>
                    <option value="19">Nuevo León</option>
                    <option value="20">Oaxaca</option>
                    <option value="21">Puebla</option>
                    <option value="22">Querétaro</option>
                    <option value="23">Quintana Roo</option>
                    <option value="24">San Luis Potosí</option>
                    <option value="25">Sinaloa</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Municipio</label>
                  <select class="browser-default" id="id_municipio" name="id_municipio" >
                    <option value="1" selected>Abasolo</option>
                    <option value="2">Acámbaro</option>
                    <option value="3">San Miguel de Allende</option>
                    <option value="4">Apaseo el Alto</option>
                    <option value="5">Apaseo el Grande</option>
                    <option value="6">Atarjea</option>
                    <option value="7">Celaya</option>
                    <option value="8">Manuel Doblado</option>
                    <option value="9">Comonfort</option>
                    <option value="10">Coroneo</option>
                    <option value="11">Cortazar</option>
                    <option value="12">Cuerámaro</option>
                    <option value="13">Doctor Mora</option>
                    <option value="14">Dolores Hidalgo Cuna de la Independencia Nacional 	</option>
                    <option value="15">Guanajuato</option>
                    <option value="16">Huanímaro</option>
                    <option value="17">Irapuato</option>
                    <option value="18">Jaral del Progreso</option>
                    <option value="19">Jerécuaro</option>
                    <option value="20">León</option>
                    <option value="21">Moroleón</option>
                    <option value="22">Ocampo</option>
                    <option value="23">Pénjamo</option>
                    <option value="24">Pueblo Nuevo</option>
                    <option value="25">Purísima del Rincón</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Nivel de Estudios</label>
                  <select class="browser-default" id="id_nivel_estudios" name="id_nivel_estudios" >
                    <option value="1" selected>Primaria</option>
                    <option value="2">Secundaria</option>
                    <option value="3">Preparatoria</option>
                    <option value="4">TSU</option>
                    <option value="5">Universidad</option>
                    <option value="6">Maestría</option>
                    <option value="7">Doctorado</option>
                    <option value="8">Otro</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Pueblo Indígena</label>
                  <select class="browser-default" id="id_pueblo_indigena" name="id_pueblo_indigena" >
                    <option value="1" selected>Otomí</option>
                    <option value="2">Chichimeca Jonaz</option>
                    <option value="3">Náhuatl</option>
                    <option value="4">Mazahua</option>
                    <option value="5">Otro</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Capacidad Diferente</label>
                  <select class="browser-default" id="id_capacidad_diferente" name="id_capacidad_diferente" >
                    <option value="1" selected>Física</option>
                    <option value="2">Sensorial</option>
                    <option value="3">Auditiva</option>
                    <option value="4">Visual</option>
                    <option value="5">Psíquica</option>
                    <option value="6">Intelectual</option>
                    <option value="7">Mental</option>
                  </select>
                </div>
                <div class="input-field col s8">
                    <input id="premios" name="premios" type="text" class="validate">
                    <label for="premios">Premios</label>
                </div>
                <div class="input-field col s8">
                    <input id="proyectos_sociales" name="proyectos_sociales" type="text" class="validate">
                    <label for="proyectos_sociales">Proyectos Sociales</label>
                </div>
                <div class="col s5">
                  <label>Apoyo de Proyectos Sociales</label>
                  <select class="browser-default" id="apoyo_proyectos_sociales" name="apoyo_proyectos_sociales" >
                    <option value="0" selected>No</option>
                    <option value="1">Sí</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Trabaja</label>
                  <select class="browser-default" id="trabaja" name="trabaja" >
                    <option value="0" selected>No</option>
                    <option value="1">Sí</option>
                  </select>
                </div>
                <div class="col s5">
                  <label>Programa beneficiario</label>
                  <select class="browser-default" id="id_programa_beneficiario" name="id_programa_beneficiario" >
                    <option value="1" selected>Municipal</option>
                    <option value="2">Estatal</option>
                    <option value="3">Federal</option>
                    <option value="4">Internacional</option>
                  </select>
                </div>
                    <div class="file-field input-field col s8">
                       <div class="btn" style="background: #BF3364;">
                          <span>Imagen</span>
                          <input type="file">
                       </div>
                       <div class="file-path-wrapper">
                          <input class="file-path validate" type="text" placeholder="Cargar imagen">
                       </div>
                    </div>
                         <div class="file-field input-field col s8">
                            <div class="btn" style="background: #BF3364;">
                               <span>Documentos</span>
                               <input type="file" multiple>
                            </div>
                            <div class="file-path-wrapper">
                               <input class="file-path validate" type="text" placeholder="Cargar documentos">
                            </div>
                         </div>
                         <div class="col offset-s5">
                           <input class="input-field btn right" style="background: #BF3364;" type="submit" value="Actualizar">
                         </div>
            </div>
        </form>
    </div>
@endsection
