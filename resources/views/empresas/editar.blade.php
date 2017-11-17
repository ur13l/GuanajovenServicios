@extends('layout.app')

@section('title')
    {{$empresa->empresa}}
@endsection

@section('cabecera')
    Promoción
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/empresas/editar.js')}}"></script>
@endsection

@section('contenedor')

    <div id="editPromocion" class="modal">
        <div class="modal-content">
            <h4>Agrega una promoción</h4>
            <div class="row">
                <form id="form-editar" method="post" action="{{url('/promociones/editar')}}" class="col s12" enctype="multipart/form-data">
                <div class="input-field col s12">
                      <input type="hidden" name="editid_promocion" id="editid_promocion">
                      <input id="editid_empresa" name="editid_empresa" type="hidden" value="{{$empresa->id_empresa}}" class="validate">
                      <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    <input id="edittitulo" name="edittitulo" type="text" class="validate">
                    <label class="isTrue" for="edittitulo">Título</label>
                </div>
                <div class="input-field col s12">
                    <input id="editdescripcion" name="editdescripcion" type="text" class="validate">
                    <label  class="isTrue" for="editdescripcion">Descripción</label>
                </div>
                <div class="input-field col s12">
                    <input id="editbases" name="editbases" type="text"  class="validate">
                    <label  class="isTrue" for="editbases">Bases</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="editfecha_inicio" name="editfecha_inicio"   class="datepicker">
                    <label class="isTrue" for="editfecha_inicio">Fecha de Apertura</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="editfecha_fin" name="editfecha_fin"  class="datepicker">
                    <label class="isTrue" for="editfecha_fin">Fecha de Cierre</label>
                </div>
                <div class="input-field col s12">
                    <input id="editcodigo_promocion" name="editcodigo_promocion" type="text"  class="validate">
                    <label class="isTrue" for="editcodigo_promocion">Código Promoción</label>
                </div>
                <div class="input-field col s12">
                    <input id="editurl_promocion" name="editurl_promocion" type="text"  class="validate">
                    <label class="isTrue" for="editurl_promocion">URL Promoción</label>
                </div>

                <input class="input-field btn right" style="background: #BF3364;" type="submit" value="EDITAR">
              </form>
              </div>
    </div>
  </div>

    <div id="addPromocion" class="modal">
        <div class="modal-content">
            <h4>Agrega una promoción</h4>
            <div class="row">
                <form id="form-editar" method="post" action="{{url('/promociones/nueva')}}" class="col s12" enctype="multipart/form-data">
                <div class="input-field col s12">
                    <input id="id_empresa" name="id_empresa" type="hidden" value="{{$empresa->id_empresa}}" class="validate">
                      <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
                    <input id="titulo" name="titulo" type="text" class="validate">
                    <label for="titulo">Título</label>
                </div>
                <div class="input-field col s12">
                    <input id="descripcion" name="descripcion" type="text" class="validate">
                    <label for="descripcion">Descripción</label>
                </div>
                <div class="input-field col s12">
                    <input id="bases" name="bases" type="text"  class="validate">
                    <label for="bases">Bases</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_inicio" name="fecha_inicio"  class="datepicker">
                    <label for="fecha_inicio">Fecha de Apertura</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_fin" name="fecha_fin"  class="datepicker">
                    <label for="fecha_fin">Fecha de Cierre</label>
                </div>
                <div class="input-field col s12">
                    <input id="codigo_promocion" name="codigo_promocion" type="text"  class="validate">
                    <label for="codigo_promocion">Código Promoción</label>
                </div>
                <div class="input-field col s12">
                    <input id="url_promocion" name="url_promocion" type="text"  class="validate">
                    <label for="url_promocion">URL Promoción</label>
                </div>
                <input class="input-field btn right" style="background: #BF3364;" type="submit" value="AGREGAR">
              </form>
              </div>
    </div>
  </div>






    <form id="form-editar" method="post" action="{{url('/empresas/editar')}}" class="col s12" enctype="multipart/form-data">
    <div class="row">
        <h2>{{$empresa->titulo}}</h2>
        <div class="s12 center-align">
        <img id="img-convocatoria" src="{{$empresa->logo}}" height="200" alt=""></div>
        <div class="file-field input-field col s12 l6 offset-l3">
            <div class="btn accent-color">
                <span>Imagen</span>
                <input type="file" id="imagen" name="imagen" >
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" value="{{$empresa->logo}}" placeholder="Cambiar imagen">
            </div>
        </div>
    </div>
    <div class="row">

        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
            {{csrf_field()}}
            <input type="hidden" name="id_empresa" value="{{$empresa->id_empresa}}">
            <div class="row">
                <div class="input-field col s12">
                    <input id="empresa" name="empresa" type="text" value="{{$empresa->empresa}}" class="validate">
                    <label for="empresa">Empresa</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="nombre_comercial" name="nombre_comercial" value="{{$empresa->nombre_comercial}}"  type="text" class="validate">
                    <label for="nombre_comercial">Nombre Comercial</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="razon_social" name="razon_social" type="text"  value="{{$empresa->razon_social}}" class="validate">
                    <label for="razon_social">Razón social</label>
                </div>
                <div class="input-field col s12 ">
                    <input id="convenio" name="convenio"   value="{{$empresa->convenio}}"  type="text" class="validate">
                    <label for="convenio">Convenio</label>
                </div>
                <div class="input-field col s12 m6">
                        <select required id="estatus" name="estatus" class="select-wrapper validate">
                          @if ($empresa->estatus === "Activo")
                          <option selected value="Activo">Activo</option>
                          <option value="Inactivo">Inactivo</option>
                          @else
                          <option  value="Activo">Activo</option>
                          <option selected value="Inactivo">Inactivo</option>
                          @endif
                        </select>
                        <label for="estatus">Estatus</label>
                </div>
                <div class="input-field col s12 m6">
                    <select required id="prioridad"  name="prioridad" class="select-wrapper validate">


                      @if ($empresa->prioridad === 1)
                      <option selected value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      @elseif ($empresa->prioridad === 2)
                      <option value="1">1</option>
                      <option  selected value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      @elseif ($empresa->prioridad === 3)
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option  selected value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      @elseif ($empresa->prioridad === 4)
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option selected value="4">4</option>
                      <option value="5">5</option>
                      @else
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option selected value="5">5</option>
                      @endif
                    </select>
                    <label for="prioridad">Prioridad</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="url_empresa" name="url_empresa" type="text" value="{{$empresa->url_empresa}}"   class="validate">
                    <label for="url_empresa">URL de empresa</label>
                </div>

                    <input class="input-field btn right" style="background: #BF3364;" type="submit" value="ACTUALIZAR">
            </div>

                <div class="divider"></div>
                <h4>Promociones</h4>
                @if(count($empresa->promociones) == 0 )
                    <p>No hay promociones registradas</p>
               @else
               <div class="section" id="doc-container">
                 <table class="highlight">
                     <thead>
                     <tr>
                         <th data-field="titulo">Título</th>
                         <th data-field="descripcion">Descripción</th>
                         <th data-field="fecha_inicio">Fecha Inicio</th>
                         <th data-field="fecha_fin">Fecha Fin</th>
                         <th data-field="editar">Editar</th>
                         <th data-field="eliminar">Eliminar</th>
                        <!--
                         <th data-field="id_promocion"></th>
                        <th data-field="codigo_promocion">Código Promoción</th>
                         <th data-field="url_promocion">URL Promoción</th>
                          <th data-field="bases">Bases</th>-->
                     </tr>
                     </thead>
                     <tbody id="tabla-eventos">
                       @foreach($empresa->promociones  as $promocion)
                  <tr class="rows">
                  <td>
                    <input type="hidden" name="id_promocionhidden" id="id_promocionhidden" value="{{$promocion->id_promocion}}">
                    <input type="hidden" name="codigo_promocionhidden" id="codigo_promocionhidden" value="{{$promocion->codigo_promocion}}">
                    <input type="hidden" name="url_promocionhidden" id="url_promocionhidden" value="{{$promocion->url_promocion}}">
                    <input type="hidden" name="baseshidden" id="baseshidden" value="{{$promocion->bases}}">
                    {{$promocion->titulo}}
                  </td>
                  <td>{{$promocion->descripcion}}</td>
                  <td class="fecha_inicio">{{$promocion->fecha_inicio}}</td>
                  <td class="fecha_fin">{{$promocion->fecha_fin}}</td>
                  <!--href="{{url('/empresas/editarPromocion/'.$promocion->id_promocion)}}"-->
                  <td> <a class="btn-floating halfway-fab waves-effect waves-light accent-color editar-button"  id="editar-button"><i class="material-icons">mode_edit</i></a></td>
                    <td><a href="{{url('/promociones/eliminarPromocion/'.$promocion->id_promocion.'/'.$empresa->id_empresa)}}" class="btn-floating halfway-fab waves-effect waves-light red" id="delete-button"><i class="material-icons">clear</i></a></td>
                </tr>
      @endforeach
                     </tbody>
                 </table>
               </div>
                @endif
  </form>
                <div class="row">
                    <div class="col s1 offset-s5">
                        <a class="btn-floating center waves-effect waves-light  center-align accent-color right" id="agrega-promocion"><i class="material-icons">add</i></a>
                    </div>
                </div>

    </div>

@endsection
