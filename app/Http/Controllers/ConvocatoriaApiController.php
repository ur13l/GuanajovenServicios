<?php

namespace App\Http\Controllers;

use App\Convocatoria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\User;
use App\DatosUsuario;
use App\Notifications\ConvocatoriaNotification;
use Auth;


class ConvocatoriaApiController extends Controller
{
    /**
     * Metodo para la obtención de convocatorias para la app.
     * @route /api/convocatorias/
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerConvocatorias(Request $request) {
        $timestamp = $request->input('timestamp');

        $convocatorias = Convocatoria::where('fecha_cierre', '>=', Carbon::now('America/Mexico_City'))
            ->where('updated_at', '>', $timestamp)
            ->orderBy('fecha_cierre')
            ->with('documentos')
            ->withTrashed()
            ->get();
        return response()->json(array(
            "success" => true,
            "status" => 200,
            "errors" => [],
            "data" => $convocatorias
        ));
    }


    /**
     * Metodo para registrar a un usuario a una convocatoria. Envía una notificación al correo.
     * @route /api/
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviarNotificacion(Request $request) {
        $usuario = Auth::guard('api')->user();
        $id_usuario = $usuario->id;
        $id_convocatoria = $request->input('id_convocatoria');
        if(isset($usuario)) {
            $usuario = User::where('id', '=', $usuario->id)->firstOrFail();
            $convocatoria = Convocatoria::find($request->id_convocatoria);
            $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->first();
            $usuario->notify(new ConvocatoriaNotification($convocatoria, $datos_usuario));
            return response()->json(array(
                "success" => true,
                "status" => 200,
                "errors" => [],
                "data" => $convocatoria
            ));
        }
        else {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => ["Usuario no registrado"]
            ));
        }
    }
}
