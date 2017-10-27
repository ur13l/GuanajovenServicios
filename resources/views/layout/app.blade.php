<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        <link rel="shortcut icon" type="image/png" href="{{ url('/img/icono.png') }}" />
        <link type="image/png" href="{{ url('/img/default-user-image.png') }}" />
        <input type="hidden" id="url" name="url" value="{{url('/')}}">
        <link rel="stylesheet" href="{{url('materialize/css/materialize.min.css')}}">
        <link rel="stylesheet" href="{{url('css/style.css')}}">
        <link rel="stylesheet" href="{{url('/css/lolliclock.css')}}">
        <link rel="stylesheet" href="{{url('/css/toastr.min.css')}}">
        <link rel="stylesheet" href="{{url('/css/nouislider.css')}}">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <script type="text/javascript" src="{{url('js/jquery-1.12.3.js')}}"></script>
        <script type="text/javascript" src="{{url('js/jquery.validate.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/lolliclock.js')}}"></script>
        <script type="text/javascript" src="{{url('materialize/js/materialize.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/ion.rangeSlider.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/moment.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/moment-with-locales.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/toastr.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/jquery.twbsPagination.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/nouislider.min.js')}}"></script>
        <script type="text/javascript" src="{{url('/js/jquery.twbsPagination.min.js')}}"></script>
        <!--<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>-->
        <script type="text/javascript">
            $(document).ready(function(){
                $(".button-collapse").sideNav();
                $('.modal-trigger').leanModal();
                $('.datepicker').pickadate({
                    selectMonths: true,
                    selectYears: 15,
                    // The title label to use for the month nav buttons
                    labelMonthNext: 'Mes siguiente',
                    labelMonthPrev: 'Mes anterior',

// The title label to use for the dropdown selectors
                    labelMonthSelect: 'Selecciona un mes',
                    labelYearSelect: 'Selecciona un año',

// Months and weekdays
                    monthsFull: [ 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre' ],
                    monthsShort: [ 'ene.', 'feb.', 'mar.', 'abr.', 'may.', 'jun.', 'jul.', 'ago.', 'sep.', 'oct.', 'nov.', 'dic.' ],
                    weekdaysFull: [ 'Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado' ],
                    weekdaysShort: [ 'Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab' ],

// Materialize modified
                    weekdaysLetter: [ 'D', 'L', 'M', 'X', 'J', 'V', 'S' ],

// Today and clear
                    today: 'Hoy',
                    clear: 'Limpiar',
                    close: 'Cerrar'
                });
                moment.locale('es');
            });
        </script>
        @yield('head')
    </head>
    <body style="background: #f1f1f1" id="body">
    <input type="hidden" id="_url" value="{{ url('/') }}">
        <!--Barra de navegación-->
        <nav>
            <div class="nav-wrapper primary-color">
                <a href="#" class="brand-logo" style="padding-left: 2.5%;">@yield('cabecera')</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                <!--  <li><a href="{{url('reportes')}}">Reportes</a></li>-->
                    <li><a href="{{url('inicio')}}">Inicio</a></li>
                    <li><a href="{{url('jovenes')}}"> Jóvenes </a></li>
                    <li><a href="{{url('eventos/inicio')}}">Eventos</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="{{url('empresas')}}">Promociones</a></li>
                    <li><a href="{{url('notificaciones')}}">Notificaciones</a></li>
                    <li><a href="{{url('chat')}}">Chat</a></li>
                    <!--<li><a href="{{url('video')}}">Video</a></li>-->
                    <li><a href="{{url('usuarios/logout')}}">Cerrar sesión</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                  <!--  <li><a href="{{url('reportes')}}">Reportes</a></li>-->
                      <li><a href="{{url('inicio')}}">Inicio</a></li>
                    <li><a href="{{url('jovenes')}}">Jóvenes</a></li>
                    <li><a href="{{url('eventos/inicio')}}">Eventos</a></li>
                    <li><a href="{{url('publicidad')}}">Publicidad</a></li>
                    <li><a href="{{url('convocatorias')}}">Convocatorias</a></li>
                    <li><a href="{{url('empresas')}}">Promociones</a></li>
                    <li><a href="{{url('notificaciones')}}">Notificaciones</a></li>
                    <li><a href="{{url('chat')}}">Chat</a></li>
                    <!--<li><a href="{{url('video')}}">Video</a></li>-->
                    <li><a href="{{url('logout.php')}}">Cerrar sesión</a></li>
                </ul>
            </div>
        </nav>
        <div class="container" id="container" style="background:white;  padding:30px; margin-top:50px;">

            @yield('contenedor')
        </div>
    </body>
</html>
