<div class="row">
    <!-- Lógica para mostrar tabla -->
    <div class="rowsection" id="table">
        @if(count($usuarios) == 0)
            <div class="section">No hay datos</div>
        @else
            <table class="highlight">
                <thead>
                <tr>
                    <th class="header" data-field="funcionario.id" style="width: 100px; cursor: pointer">Código</th>
                    <th class="header" data-field="datos_usuario.nombre" style="width: 150px; cursor: pointer">Nombre
                    </th>
                    <th class="header" data-field="datos_usuario.apellido_paterno"
                        style="width: 100px; cursor: pointer">Apellido Paterno
                    </th>
                    <th class="header" data-field="datos_usuario.apellido_materno"
                        style="width: 100px; cursor: pointer">Apellido Materno
                    </th>
                    <th class="header" data-field="datos_usuario.curp" style="width: 100px; cursor: pointer">CURP</th>
                    <th class="header" data-field="usuario.email" style="width: 100px; cursor: pointer">Correo
                        electrónico
                    </th>
                    <th class="header" data-field="funcionario.telefono" style="width: 100px; cursor: pointer">
                        Teléfono
                    </th>
                    <th class="header" data-field="rol.nombre_vista" style="width: 100px; cursor: pointer">Rol</th>
                    <th class="header" data-field="puesto.nombre_vista" style="width: 100px; cursor: pointer">Puesto
                    </th>
                    <!--<th data-field="editar">Editar</th>
                    <th data-field="eliminar">Eliminar</th>-->
                </tr>
                </thead>

                <tbody id="tabla-usuarios">
                @foreach($usuarios as $user)
                    <td style="width: 100px">{{$user->id}}</td>
                    <td style="width: 150px">{{$user->usuario()->datosUsuario()->first()->nombre}}</td>
                    <td style="width: 100px">{{$user->usuario()->datosUsuario()->first()->apellido_paterno}}</td>
                    <td style="width: 100px">{{$user->usuario()->datosUsuario()->first()->apellido_materno}}</td>
                    <td style="width: 100px">{{$user->usuario()->datosUsuario()->first()->curp}}</td>
                    <td style="width: 100px">{{$user->usuario()->email}}</td>
                    <td style="width: 100px">{{$user->telefono}}</td>
                    <td style="width: 100px">{{$user->rol()->nombre_vista}}</td>
                    <td style="width: 100px">{{$user->puesto()->nombre}}</td>
                    <!--<td class="center-align"><i class="material-icons grey-text" style="cursor: pointer" data-user-id="{{$user->id}}">mode_edit</i></td>
                            <td class="center-align"><i class="material-icons grey-text borrar" style="cursor: pointer" data-user-id="{{$user->id}}">delete</i></td>-->
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <ul class="pagination">
            {{$usuarios->links()}}
        </ul>
    </div>

    <div class="fixed-action-btn" style="bottom: 10px; right: 24px;">
        <a href="{{url('usuarios/nuevo')}}" class="btn-floating btn-large waves-effect waves-light btn modal-trigger"
           style="background: #BF3364;">
            <i class="material-icons" id="new-Pub">add</i>
        </a>
    </div>

</div>
