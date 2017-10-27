@extends('layout.app')

@section('title')
    Nuevo Usuario
@endsection

@section('cabecera')
    Usuarios
@endsection

@section('head')
    <script type="text/javascript" src="{{url('/js/jquery.validate.js')}}"></script>
    <script src="{{url('/js/usuarios/nuevo.js')}}"></script>
@endsection

@section('contenedor')
    <div class="row">
        <h2>Nuevo Usuario</h2>
    </div>
    <div class="row">
        @foreach($errors->all() as $error)
            <div class="red-text">{{$error}}</div>
        @endforeach
        <form id="form-crear" method="post" action="{{url('/empresas/crear')}}" class="col s12"
              enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="row">

                <div class="input-field col s12">
                    <input id="curp" name="curp" type="text" class="validate" maxlength="18"
                           style="text-transform: uppercase">
                    <label for="curp">CURP</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="nombre" name="nombre" type="text" class="validate">
                    <label for="nombre">Nombre</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="apellido_paterno" name="apellido_paterno" type="text" class="validate">
                    <label for="apellido_paterno">Apellido Paterno</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="apellido_materno" name="apellido_materno" type="text" class="validate">
                    <label for="apellido_materno">Apellido Materno</label>
                </div>

                <div class="input-field col s12 ">
                    <input readonly id="fecha_nacimiento" name="fecha_nacimiento" type="text" class="validate">
                    <label for="fecha_nacimiento">Fecha nacimiento</label>
                </div>

                <div class="input-field col s12 ">
                    <input id="correo" name="correo" type="email" class="validate">
                    <label for="correo">Correo electrónico</label>
                </div>

                <div class="input-field col s12 ">
                    <input id="telefono" name="telefono" type="tel" class="validate">
                    <label for="telefono">Teléfono</label>
                </div>

                <div class="input-field col s12">
                    <select required id="rol" name="rol" class="select-wrapper validate">
                        <option value="" selected>Elige una opción</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->id }}">{{ $rol->nombre_vista }}</option>
                        @endforeach
                    </select>
                    <label for="rol">Rol</label>
                </div>

                <div class="col s12">
                    <ul class="list-group">
                        @foreach($permisos as $permiso)
                            <li id="{{ $permiso->id }}" class="list-group-item">{{ $permiso->nombre_vista }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="input-field col s12">
                    <select required id="puesto" name="puesto" class="select-wrapper validate">
                        <option value="" selected>Elige una opción</option>
                        @foreach($puestos as $puesto)
                            <option value="{{ $puesto->id }}">{{ $puesto->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="puesto">Puesto</label>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($areas as $area)
                            <li class="list-group-item">{{ $area->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($direcciones as $direccion)
                            <li class="list-group-item">{{ $direccion->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="col s4">
                    <ul class="list-group">
                        @foreach($dependencias as $dependencia)
                            <li class="list-group-item">{{ $dependencia->nombre }}</li>
                        @endforeach
                    </ul>
                </div>

                <input class="input-field btn right" style="background: #BF3364;" type="submit" value="Registrar">
            </div>
        </form>
    </div>

    <script>
        $(function () {
            $('#curp').keyup(function () {
                if ($('#curp').val().length === 18) {
                    var curp = $('#curp').val().toLocaleUpperCase();
                    $.ajax({
                        type: "POST",
                        url: 'curp',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: {
                            curp: curp
                        },
                        success: function (data) {
                            $('#nombre').val(data.data.nombres).trigger('change');
                            $('#apellido_paterno').val(data.data.PrimerApellido).trigger('change');
                            $('#apellido_materno').val(data.data.SegundoApellido).trigger('change');
                            $('#fecha_nacimiento').val(data.data.fechNac).trigger('change')
                        },
                        error: function (data) {
                            console.log('Error:', data);
                        }
                    });
                } else if ($('#curp').val().length < 18) {
                    $('#nombre').val('')
                    $('#apellido_paterno').val('');
                    $('#apellido_materno').val('');
                    $('#fecha_nacimiento').val('');
                }
            });

            $('#rol').change(function () {
                var id_rol = $('#rol').val();

                $.ajax({
                    type: 'POST',
                    url: 'obtenerPermisos',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        id_rol : id_rol
                    },
                    success: function(data) {
                        
                        console.log(data.permisos_rol);

                        $.each(data.permisos_rol, function(index, value) {
                            $('#' + value.id).attr('class', 'list-group-item list-group-item-info');
                        });

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

            })
        })
    </script>

@endsection
