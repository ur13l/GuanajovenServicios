@extends('layout.app')

@section('title')
    {{$convocatoria->titulo}}
@endsection

@section('cabecera')
    Convocatoria
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/convocatorias/editar.js')}}"></script>
@endsection

@section('contenedor')

    <!--Modal eliminar-->
    <div id="deleteModalDoc" class="modal">
        <div class="modal-content">
            <h4>Confirmar</h4>
            <p id="delete-message">¿Desea eliminar el documento?</p>
            <input type="hidden" name="id-eliminar" id="id-eliminar">
            <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
            <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
        </div>
    </div>
    <form id="form-editar" method="post" action="{{url('/convocatorias/editar')}}" class="col s12" enctype="multipart/form-data">
    <div class="row">
        <h2>{{$convocatoria->titulo}}</h2>
        <div class="s12 center-align">
        <img id="img-convocatoria" src="{{$convocatoria->ruta_imagen}}" height="200" alt=""></div>
        <div class="file-field input-field col s12 l6 offset-l3">
            <div class="btn accent-color">
                <span>Imagen</span>
                <input type="file" id="imagen" name="imagen" >
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" value="{{$convocatoria->ruta_imagen}}" placeholder="Cambiar imagen">
            </div>
        </div>
    </div>
    <div class="row">

        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach


            {{csrf_field()}}
            <input type="hidden" name="input-deleted-docs" id="input-deleted-docs" value="[]">
            <input type="hidden" name="id_convocatoria" value="{{$convocatoria->id_convocatoria}}">
            <div class="row">
                <div class="input-field col s12">
                    <input id="titulo" name="titulo" type="text" value="{{$convocatoria->titulo}}" class="validate">
                    <label for="titulo">Título</label>
                </div>

                <div class="input-field col s12">
                    <textarea id="descripcion" name="descripcion" class="materialize-textarea"> {{$convocatoria->descripcion}}</textarea>
                    <label for="descripcion">Descripción</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_inicio" name="fecha_inicio" value="{{ explode(' ', $convocatoria->fecha_inicio)[0]}}"  class="datepicker">
                    <label for="fecha_inicio" class="active">Fecha de Apertura</label>
                </div>
                <div class="input-field col s12 m6">
                    <input id="fecha_cierre" name="fecha_cierre" value="{{explode(' ', $convocatoria->fecha_cierre)[0]}}"  class="datepicker">
                    <label for="fecha_cierre" class="active">Fecha de Cierre</label>
                </div>
            </div>
                <div class="divider"></div>
                <div class="section" id="doc-container">
                    <h5>Documentos</h5>
                        @foreach($convocatoria->documentos as $index => $documento)

                        <div class="section hoverable">
                                <input type="hidden" name="doc-id[]" value="{{$documento->id_documento}}">
                            <div class="row">
                                <div class="col m2 hide-on-small-and-down">
                                    <span class="col l12 center-align">
                                    @if($documento->id_formato == 1)
                                        <img src="{{url('/img/ic_pdf.png')}}" alt="">
                                    @elseif($documento->id_formato == 2)
                                        <img src="{{url('/img/ic_doc.png')}}" alt="">
                                    @elseif($documento->id_formato == 3)
                                        <img src="{{url('/img/ic_xls.png')}}" alt="">
                                    @else
                                        <img src="{{url('/img/ic_unknow.png')}}" alt="">
                                    @endif
                                    </span>
                                </div>
                                <div class="input-field col s5 l6">
                                    <input id="doc-titulo[]" name="doc-titulo[]" type="text" value="{{$documento->titulo}}" class="validate">
                                    <label for="titulo">Título</label>
                                </div>
                                <div class="file-field input-field col s5 m3 l2 ">
                                    <div class="btn accent-color">
                                        <span>Cambiar </span>
                                        <input type="file" class="input-doc-file" name="doc-file-{{$documento->id_documento}}" >
                                    </div>
                                </div>
                                <div class="col s2">
                                    <p class="col s12 center-align">
                                        <a data-id="{{$documento->id_documento}}" class="large center center-align delete-doc grey-text" style="margin-top:30px; cursor: pointer" ><i class="material-icons">delete</i></a>
                                    </p>
                                </div>
                            </div>
                            </div>
                        @endforeach
                    @if(count($convocatoria->documentos) == 0 )
                        <p>No hay documentos registrados</p>
                    @endif


                </div>
                <div class="row">
                    <div class="col s1 offset-s5">
                        <a class="btn-floating center waves-effect waves-light  center-align accent-color right" id="agregar-documento"><i class="material-icons">add</i></a>
                    </div>
                </div>
                <input class="input-field btn right primary-color" type="submit" value="Actualizar">



    </div>
    </form>
@endsection
