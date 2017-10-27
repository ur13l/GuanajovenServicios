@extends('layout.app')

@section('title')
    {{ $titulo }}
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
@endsection

@section('cabecera')
    Eventos
@endsection

@section('contenedor')
    <div class="row">
        <h2>{{ $titulo }}</h2>
    </div>
    <div class="row" style="height: 350px;">
        <div id="map" style="height: 100%;"></div>
    </div>
    <div class="row">
        <form class="col s12" action="{{ url('/eventos/guardar') }}" method="post" id="form-nuevo-evento">
            <input type="hidden" id="posicion" name="posicion" value="">
            <input type="hidden" id="accion" name="accion" value="{{$accion}}">
            <input type="hidden" id="id_evento" name="id_evento" value="{{$evento->id_evento}}">
            <div class="row">
                <div class="input-field col s12">
                    <input id="titulo" type="text" class="vald" name="titulo" value="{{ $evento->titulo }}" required>
                    <label for="titulo">Título</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="descripcion" class="materialize-textarea vald" name="descripcion" maxlength="200" required>{{ $evento->descripcion }}</textarea>
                    <label for="descripcion">Descripción</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-inicio" type="text" class="datepicker vald" value="{{ $fecha_inicio }}" name="fecha_inicio" required>
                    <label for="fecha-inicio">Fecha de inicio</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-inicio" type="text" class="timepicker vald" value="{{ date_format(date_create($hora_inicio), 'H:i') }}" name="hora_inicio" required>
                    <label for="hora-inicio">Hora de inicio</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input id="fecha-fin" type="text" class="datepicker vald" value="{{ $fecha_fin }}" name="fecha_fin" required>
                    <label for="fecha-fin">Fecha de finalización</label>
                </div>
                <div class="input-field col s6">
                    <input id="hora-fin" type="text" class="timepicker vald" value="{{ date_format(date_create($hora_fin), 'H:i') }}" name="hora_fin" required>
                    <label for="hora-fin">Hora de finalización</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input type="number" class="vald" id="puntos-otorgados" value="{{ $evento->puntos_otorgados }}" name="puntos-otorgados" required>
                    <label for="puntos-otorgados">Puntos otorgados</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" class="vald" id="area-responsable" value="{{ $evento->area_responsable }}" name="area-responsable" required>
                    <label for="area-responsable">Área responsable</label>
                </div>
            </div>

            <div class="row">
                <div class="input-field col s12">
                    <select required id="tipo-evento" name="tipo-evento" class="validate">
                        <option value="" disabled>Elige una opción</option>
                        @foreach($tipos as $tipo)
                            @if($evento->id_tipo_evento == $tipo->id_tipo_evento)
                             <option value="{{$tipo->id_tipo_evento}}" selected>{{$tipo->nombre}}</option>
                            @else
                             <option value="{{$tipo->id_tipo_evento}}">{{$tipo->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                    <label>Tipo de evento</label>
                    <input type="hidden" name="tipo-seleccionado" val="{{$evento->id_tipo_evento}}" id="tipo-seleccionado">
                </div>
            </div>

            <div class="row">
                <button type="button" class="waves-effect waves-light btn rose-code" id="guardar-evento" style="background: #BF3364;">
                    <i class="material-icons left">library_books</i>Guardar
                </button>
            </div>
        </form>
    </div>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: Number('{{ $latitud }}'),
                    lng: Number('{{ $longitud }}')
                },
                zoom: 15
            });
            var marca = null;

            var pos = {
                lat: Number('{{ $latitud }}'),
                lng: Number('{{ $longitud }}')
            };

            marca = new google.maps.Marker({
                position: pos,
                map: map,
                draggable: true,
                title: 'Evento'
            });

            $('#posicion').val(marca.getPosition());
            map.setCenter(pos);

            map.addListener('mouseout', function() {
                $('#posicion').val(marca.getPosition());
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBHm6Cez6yYXKGHBxPBGFZtFUuJ_O8FOwI&callback=initMap"
            async defer></script>
    <script type="text/javascript">
        @if(isset($mensaje))
            Materialize.toast('{{ $mensaje }}', 4000, "red");
        @endif
    </script>
@endsection
