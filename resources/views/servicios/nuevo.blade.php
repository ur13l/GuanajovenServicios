@extends('layout.app')

@section('title')
    Servicios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script type="text/javascript" src="{{url('/js/servicio/index.js')}}"></script>

@endsection

@section('cabecera')
    Servicios
@endsection

@section('contenedor')
<div class="row">
    <h4>Nuevo Servicio</h4>
</div>
<div class="row">
    @foreach($errors->all() as $error)
      <div class="red-text">{{$error}}</div>
    @endforeach
    <form id="form-ns" method="post" action="{{url('/servicio/registrar')}}" class="col s12" enctype="multipart/form-data">
        <!--Editar nombres según BD -->
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="capturista" name="capturista" type="text" class="validate">
                <label for="capturista">Capturista</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="id_orden" name="id_orden" type="text" class="validate">
                <label for="id_orden">Id. Orden</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="region_responsable" name="region_responsable" type="text" class="validate">
                <label for="region_responsable">Región responsable</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="region_responsable" name="region_responsable" type="text" class="validate">
                <label for="region_responsable">Región responsable</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m6">
                <input id="centro_poder_joven" name="centro_poder_joven" type="text" class="validate">
                <label for="centro_poder_joven">Centro Poder Joven</label>
            </div>
        </div>
        <div class="input-field col s12">
    <select multiple>
      <option value="" disabled selected>Choose your option</option>
      <option value="1">Option 1</option>
      <option value="2">Option 2</option>
      <option value="3">Option 3</option>
    </select>
    <label>Materialize Multiple Select</label>
  </div>
    </form>
</div>

@endsection


