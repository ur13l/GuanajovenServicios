<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use App\NotificacionConvocatoria;
use Illuminate\Http\Request;
use App\User;
use App\Convocatoria;
use App\Notifications\ConvocatoriaNotification;

class ConvocatoriaNotificacionController extends Controller
{

    public function enviarNotificacion(Request $request) {
        $id_usuario = $request->input('id_usuario');
        $id_convocatoria = $request->input('id_convocatoria');
        if (NotificacionConvocatoria::where('id_usuario', $id_usuario)->where( 'id_convocatoria', $id_convocatoria)->count() > 0) {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => ["Ya estás registrado esta convocatoria"]
            ));
        } else {
            $usuario = User::where('id', '=', $request->id_usuario)->firstOrFail();
            $convocatoria = Convocatoria::where('id_convocatoria', '=', $request->input('id_convocatoria'))->firstOrFail();
            $datos_usuario = DatosUsuario::where('id_usuario', '=', $request->input('id_usuario'))->firstOrFail();
            $usuario->notify(new ConvocatoriaNotification($convocatoria, $datos_usuario));
        }
    }

}
