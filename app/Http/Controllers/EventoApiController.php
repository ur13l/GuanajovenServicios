<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use App\Evento;
use App\NotificacionEvento;
use App\Notifications\EventoNotificacion;
use App\User;
use Illuminate\Http\Request;

class EventoApiController extends Controller {

	public function obtenerEventos(Request $request) {
		$timestamp  = $request->input('timestamp');

		$eventos = Evento::where('updated_at','>', $timestamp)
		->orderBy('created_at')
		->withTrashed()
		->get();

		return response()->json(array(
			'status' => 200,
			'success' => true,
			'errors' => [],
			'data' => $eventos
		));
	}

	public function marcarEvento(Request $request) {
	    $idEvento = $request->input('id_evento');
	    $apiToken = $request->input('api_token');
	    $latitudUsuario = $request->input('latitud');
	    $longitudUsuario = $request->input('longitud');

	    $evento = Evento::find($idEvento);
	    $latitudEvento = $evento->latitud;
	    $longitudEvento = $evento->longitud;
	    $usuario = User::where('api_token', $apiToken)->first();

        $radioTierra = 6378.137;
        $degrees = pi()/180;

        $latitudUsuario = $latitudUsuario * $degrees;
        $longitudUsuario = $longitudUsuario * $degrees;
        $latitudEvento = $latitudEvento * $degrees;
        $longitudEvento = $longitudEvento * $degrees;

        $distanciaLongitud = $longitudUsuario - $longitudEvento;

        $distanciaTotal = acos(sin($latitudEvento) * sin($latitudUsuario) + cos($latitudEvento) *
                          cos($latitudUsuario) * cos($distanciaLongitud)) * $radioTierra;

        $distanciaMetros = $distanciaTotal * 1000;

        if ($distanciaMetros <= 500) {
            $notificacion = NotificacionEvento::where('id_evento', $idEvento)
                                              ->where('id_usuario', $usuario->id)
                                              ->first();
            $notificacion->asistio = 1;
            $notificacion->save();

            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => [
                    'puntos_otorgados' => $evento->puntos_otorgados,
                    'asistio' => 1
                ]
            ));
        } else {
            return response()->json(array(
                'status' => 500,
                'success' => false,
                'errors' => [],
                'data' => [
                    'puntos_otorgados' => 0,
                    'asistio' => 0
                ]
            ));
        }
    }
}
