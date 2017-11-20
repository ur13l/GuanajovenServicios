<div class="row">
        <!-- Lógica para mostrar tabla -->
        <div class="rowsection" style="padding-bottom:10px" id="table">
            @if(count($ordenes) == 0)
            <div class="section">No hay datos</div>
            @else
            <table class="highlight">
                <thead>
                    <tr>
                        <th class="header" data-field="id_orden_atencion" style="width: 100px; cursor: pointer">ID<i class="material-icons grey-text" id="arrow">{{$columna === "id_orden_atencion" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="fecha_inicio" style="width: 150px; cursor: pointer">Fecha inicio<i class="material-icons grey-text" id="arrow">{{$columna === "fecha_inicio" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="area.nombre" style="width: 150px; cursor: pointer">Área<i class="material-icons grey-text" id="arrow">{{$columna === "area.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="datos_usuario_responsable.nombre" style="width: 150px; cursor: pointer">Ejecutivo de atención<i class="material-icons grey-text" id="arrow">{{$columna === "datos_usuario_responsable.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="datos_joven_responsable.nombre" style="width: 150px; cursor: pointer">Joven atendido<i class="material-icons grey-text" id="arrow">{{$columna === "datos_joven_responsable.nombre" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="datos_joven_responsable.curp" style="width: 150px; cursor: pointer">CURP<i class="material-icons grey-text" id="arrow">{{$columna === "datos_joven_responsable.curp" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="joven_responsable.email" style="width: 150px; cursor: pointer">Email<i class="material-icons grey-text" id="arrow">{{$columna === "joven_responsable.email" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="titulo" style="width: 150px; cursor: pointer">Título<i class="material-icons grey-text" id="arrow">{{$columna === "titulo" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th class="header" data-field="estatus" style="width: 100px; cursor: pointer">Estatus<i class="material-icons grey-text">{{$columna === "estatus" ? ($tipo === "def" ? "unfold_more" : ($tipo === "asc" ? "expand_less" : "expand_more")) : "unfold_more"}}</i></th>
                        <th data-field="editar">Editar</th>
                        <th data-field="eliminar">Eliminar</th>
                    </tr>   
                </thead>
                <tbody id="tabla-orden">
                        @foreach($ordenes as $orden)
                            <tr>
                                <td style="width: 100px;">{{$orden->id_orden_atencion}}</td>
                                <td style="width: 150px;">{{$orden->fecha_inicio->format('d/m/Y')}}</td>
                                <td style="width: 150px;">{{$orden->area->nombre}}</td>
                                <td style="width: 150px;">{{$orden->usuarioResponsable->datosUsuario->nombre}}</td>
                                <td style="width: 150px;">{{$orden->jovenResponsable->datosUsuario->nombre}}</td>
                                <td style="width: 150px;">{{$orden->jovenResponsable->datosUsuario->curp}}</td>
                                <td style="width: 150px;">{{$orden->jovenResponsable->email}}</td>
                                <td style="width: 150px;">{{$orden->titulo}}</td>
                                <td style="width: 150px;">{{$orden->estatus()}}</td>
                                <td class="center-align"><a href="{{url('servicios/editar/'.$orden->id_orden_atencion)}}"><i class="material-icons grey-text editar" style="cursor: pointer" data-orden-id="{{$orden->id_orden_atencion}}">mode_edit</i></a></td>
                            <td class="center-align"><i class="material-icons grey-text borrar" style="cursor: pointer" data-orden-id="{{$orden->id_orden_atencion}}">delete</i></td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            @endif
            <ul class="pagination">
                {{$ordenes->links()}}
            </ul>
        </div>
    </div>