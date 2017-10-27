@extends('layout.app')

@section('title')
    Eventos
@endsection

@section('cabecera')
    Eventos
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/eventos.js')}}"> </script>
@endsection

@section('contenedor')

    <!--Modal eliminar-->
    <div id="deleteModalEv" class="modal">
        <form action="{{url('/eventos/eliminar')}}" method="post">
            <div class="modal-content">
                <h4>Confirmar</h4>
                <p id="delete-message">¿Desea eliminar el evento?</p>
                <input type="hidden" name="idEvento" id="id-eliminar">
                <input type="hidden" name="_token" id="_token" value="{{csrf_token()}}">
            </div>
            <div class="modal-footer">
                <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancelar</a>
                <input type="submit" href="#" class="waves-effect waves-green btn-flat"  value="Sí" id="yesBtn"/>
            </div>
        </form>
    </div>

    <div class="row">
        <table class="highlight">
            <thead>
            <tr>
                <!--<th data-field="check"></th>-->
                <th data-field="titulo">Título</th>
                <th data-field="descripcion">Descripción</th>
                <th data-field="fecha_inicio">Inicia</th>
                <th data-field="fecha_fin">Termina</th>
                <th data-field="fecha_fin">Estadísticas</th>
                <th data-field="fecha_fin">Editar</th>
                <th data-field="eliminar">Eliminar</th>

            </tr>
            </thead>

            <tbody id="tabla-eventos">
                @foreach($eventos as $evento)
                    @include('eventos.vistaEvento', ['evento' => $evento])
                @endforeach
            </tbody>
        </table>
    </div>


    <div class="paginacion">
        {{ $eventos->links() }}
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Detalles del evento</h4>
            <p>
            <div class="row">
                <form class="col s12">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="titulo" type="text" class="vald">
                            <label for="titulo">Título</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="descripcion" class="materialize-textarea vald"></textarea>
                            <label for="descripcion">Descripción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="fecha-inicio" type="text" class="datepicker vald" >
                            <label for="fecha-inicio">Fecha de inicio</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="hora-inicio" type="text" class="timepicker vald">
                            <label for="hora-inicio">Hora de inicio</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input id="fecha-fin" type="text" class="datepicker vald">
                            <label for="fecha-fin">Fecha de finalización</label>
                        </div>
                        <div class="input-field col s6">
                            <input id="hora-fin" type="text" class="timepicker vald">
                            <label for="hora-fin">Hora de finalización</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select required id="tipo" class="validate">
                                <option value="" disabled>Elige una opción</option>
                                <option value="1" selected>Competencia de deportista olímpico</option>
                                <option value="2">Información general</option>
                            </select>
                            <label>Tipo de evento</label>
                        </div>

                    </div>
                </form>
            </div>
            </p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action waves-effect waves-green btn-flat" id="guardar-evento">Guardar</a>
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cancelar</a>
        </div>
    </div>
    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('eventos/nuevo')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger" style="background: #BF3364;">
            <i class="material-icons" id="new-event">add</i>
        </a>
    </div>
    <div class="fixed-action-btn" id="delete-selection" style="display:none; bottom: 10px; right: 100px;">
        <a class="btn-floating btn-large waves-effect waves-light btn" style="background: #BF3364;">
            <i class="material-icons" id="new-event">delete</i>
        </a>
    </div>
@endsection
