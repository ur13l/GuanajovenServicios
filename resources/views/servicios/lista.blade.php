<div class="row">
        <!-- Lógica para mostrar tabla -->
        <div class="rowsection" style="overflow: auto; padding-bottom:10px" id="table">
            @if(count($usuarios) == 0)
            <div class="section">No hay datos</div>
            @else
            <table class="highlight">
                <thead>
                    <tr>
                        <th class="header" data-field="datos_usuario.nombre" style="width: 150px; cursor: pointer">Joven atendido<i class="material-icons grey-text" id="arrow">{{$columna === "datos_usuario.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="datos_usuario.curp" style="width: 100px; cursor: pointer">CURP<i class="material-icons grey-text">{{$columna === "datos_usuario.curp" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="usuario.email" style="width: 100px; cursor: pointer">Correo electrónico<i class="material-icons grey-text">{{$columna === "usuario.email" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th data-field="editar">Editar</th>
                        <th data-field="eliminar">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="tabla-usuarios">
                        @foreach($usuarios as $user)
                            <tr>
                                <td style="width: 150px;">{{isset($user->datosUsuario) ? $user->datosUsuario->nombre : ""}} {{isset($user->datosUsuario) ? $user->datosUsuario->apellido_paterno : ""}} {{isset($user->datosUsuario) ? $user->datosUsuario->apellido_materno : ""}}</td>
                                
                                <td style="width: 100px;">{{isset($user->datosUsuario) ? $user->datosUsuario->curp : ""}}</td>
                                <td style="width: 100px;">{{$user->email}}</td>
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