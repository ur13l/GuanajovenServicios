<div class="row">
    <!-- Lógica para mostrar tabla -->
    <div class="rowsection" style="overflow: auto; padding-bottom:10px" id="table">
        @if(count($usuarios) == 0)
        <div class="section">No hay datos</div>
        @else
        <table class="highlight">
            <thead>
                <tr>
                    <th class="header" data-field="codigo_guanajoven.id_codigo_guanajoven" style="width: 100px; padding-left: 10px; cursor: pointer">Código<i class="material-icons grey-text">{{$columna === "codigo_guanajoven.id_codigo_guanajoven" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="datos_usuario.nombre" style="width: 150px; cursor: pointer">Nombre<i class="material-icons grey-text" id="arrow">{{$columna === "datos_usuario.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="datos_usuario.apellido_paterno" style="width: 100px; cursor: pointer">Apellido Paterno<i class="material-icons grey-text">{{$columna === "datos_usuario.apellido_paterno" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="datos_usuario.apellido_materno" style="width: 100px; cursor: pointer">Apellido Materno<i class="material-icons grey-text">{{$columna === "datos_usuario.apellido_materno" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="datos_usuario.curp" style="width: 100px; cursor: pointer">CURP<i class="material-icons grey-text">{{$columna === "datos_usuario.curp" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="usuario.email" style="width: 100px; cursor: pointer">Correo electrónico<i class="material-icons grey-text">{{$columna === "usuario.email" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="municipio.nombre" style="width: 100px; cursor: pointer">Municipio<i class="material-icons grey-text">{{$columna === "municipio.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="genero.nombre"style="width: 100px; cursor: pointer">Género<i class="material-icons grey-text">{{$columna === "genero.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="datos_usuario.fecha_nacimiento" style="width: 100px; cursor: pointer">Edad<i class="material-icons grey-text">{{$columna === "datos_usuario.fecha_nacimiento" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th class="header" data-field="usuario.created_at" style="width: 100px; cursor: pointer">Fecha de registro<i class="material-icons grey-text">{{$columna === "usuario.created_at" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                    <th data-field="editar">Editar</th>
                    <th data-field="eliminar">Eliminar</th>
                </tr>
            </thead>
            <tbody id="tabla-usuarios">
                    @foreach($usuarios as $user)
                        <tr>
                            <td style="width: 100px; padding-left: 10px;" >{{isset($user->codigoGuanajoven) ? $user->codigoGuanajoven->id_codigo_guanajoven : ""}}</td>
                            <td style="width: 150px;">{{isset($user->datosUsuario) ? $user->datosUsuario->nombre : ""}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_paterno : ""}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->apellido_materno : ""}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->curp : ""}}</td>
                            <td style="width: 100px;">{{$user->email}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->municipio->nombre : ""}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->genero->nombre: ""}}</td>
                            <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->fecha_nacimiento->diffInYears(\Carbon\Carbon::now()) : ""}}</td>
                            <td style="width: 100px;">{{$user->created_at->format('d/m/Y')}}</td> 
                            <td class="center-align"><a href="{{url('jovenes/perfil/'.$user->id)}}"><i class="material-icons grey-text editar" style="cursor: pointer" data-user-id="{{$user->id}}">mode_edit</i></a></td>
                            <td class="center-align"><i class="material-icons grey-text borrar" style="cursor: pointer" data-user-id="{{$user->id}}">delete</i></td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        @endif
        <ul class="pagination">
            {{$usuarios->links()}}
        </ul>
    </div>
</div>