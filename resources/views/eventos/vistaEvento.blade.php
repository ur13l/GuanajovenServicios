<tr class="item-evento">
    <input type="hidden" class="id" value="{{ $evento->id_evento }}">
    <!--<td class="check">
        <input type="checkbox" id="chk{{ $evento->id_evento }}" class="filled-in chk checkbox-accent-color" />
        <label for="chk{{ $evento->id_evento }}"></label>
    </td>-->
    <td class='titulo'>{{ $evento->titulo }}</td>
    <td class='descripcion'>{{ $evento->descripcion }}</td>
    <td class='fInicio'>{{ date_create($evento->fecha_inicio)->format('d/m/Y H:i:s') }}</td>
    <td class='fFin'>{{ date_create($evento->fecha_fin)->format('d/m/Y H:i:s') }}</td>
    <input class='tipo' type='hidden' value='{{ $evento->tipo }}'>
    <td class="estadisticas-{{ $evento->id_evento }}">
        {!! Form::open(['url' => '/eventos/estadisticas/' . $evento->id_evento, 'method' => 'POST', 'id' => 'estadisticaEvento-' . $evento->id_evento]) !!}
            <i class='material-icons' style='cursor:pointer' onclick="$('#estadisticaEvento-{{ $evento->id_evento }}').submit();">insert_chart</i>
        {!! Form::close() !!}
    </td>
    <td class='edit'>
        {!! Form::open(['url' => '/eventos/editar/' . $evento->id_evento, 'method' => 'POST', 'id' => 'editarEvento-' . $evento->id_evento]) !!}
            <i class='material-icons' style='cursor:pointer' onclick="$('#editarEvento-{{ $evento->id_evento }}').submit();">edit</i>
        {!! Form::close() !!}
    </td>
    <td class='delete'>
        <i class='material-icons deleteP' data-id="{{$evento->id_evento}}" style='cursor:pointer'>delete</i>
    </td>
</tr>
