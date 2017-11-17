<?php

namespace App\Http\Controllers;

use App\CodigoGuanajoven;
use App\DatosUsuario;
use App\Evento;
use Auth;
use App\NotificacionEvento;
use App\Notifications\EventoNotificacion;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EventoApiController extends Controller
{

    /**
     * Eventos: Obtener
     * Devuelve la lista de eventos activos.
     */
    public function obtenerEventos(Request $request)
    {
        $timestamp = $request->input('timestamp');
        $eventos = Evento::where('updated_at', '>', $timestamp)
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

    /**
     * Evento: Marcar
     * params: [id_evento, api_token, latitud, longitud]
     * Método para indicar que a un usuario está en el área de un evento.
     */
    public function marcarEvento(Request $request)
    {
        $idEvento = $request->input('id_evento');
        $apiToken = $request->input('api_token');
        $latitudUsuario = $request->input('latitud');
        $longitudUsuario = $request->input('longitud');

        $evento = Evento::find($idEvento);
        $latitudEvento = $evento->latitud;
        $longitudEvento = $evento->longitud;
        $usuario = User::where('api_token', $apiToken)->first();

        $radioTierra = 6378.137;
        $degrees = pi() / 180;

        $latitudUsuario = $latitudUsuario * $degrees;
        $longitudUsuario = $longitudUsuario * $degrees;
        $latitudEvento = $latitudEvento * $degrees;
        $longitudEvento = $longitudEvento * $degrees;

        $distanciaLongitud = $longitudUsuario - $longitudEvento;

        $distanciaTotal = acos(sin($latitudEvento) * sin($latitudUsuario) + cos($latitudEvento) *
                cos($latitudUsuario) * cos($distanciaLongitud)) * $radioTierra;

        $distanciaMetros = $distanciaTotal * 1000;

        if ($distanciaMetros <= 500) {
            if (NotificacionEvento::where('id_evento', '=', $idEvento)->where('id_usuario', '=', $usuario->id)->where('asistio', '=', 1)->count() == 0) {
                $notificacion = NotificacionEvento::where('id_evento', $idEvento)->where('id_usuario', $usuario->id)->first();

                if ($notificacion == null) {
                    $registro = new NotificacionEvento();
                    $registro->id_usuario = $usuario->id;
                    $registro->id_evento = $idEvento;
                    $registro->asistio = 1;
                    $notificacion = $registro;
                }

                $notificacion->asistio = 1;
                $notificacion->save();

                $puntaje = $usuario->puntaje;
                $sumaPuntajes = $puntaje + $evento->puntos_otorgados;
                $usuario->update(['puntaje' => $sumaPuntajes]);

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
                    'errors' => ['Ya has sido registrado'],
                    'data' => [
                        'puntos_otorgados' => 0,
                        'asistio' => 0
                    ]
                ));
            }
        } else {
            return response()->json(array(
                'status' => 500,
                'success' => false,
                'errors' => ['No te encuentras en el rango del evento'],
                'data' => [
                    'puntos_otorgados' => 0,
                    'asistio' => 0
                ]
            ));
        }
    }

    public function registrar(Request $request)
    {
        $token = $request->input('token');
        $idEvento = $request->input('id_evento');
        $fechaActual = Carbon::now('America/Mexico_City')->toDateTimeString();
        $codigoGuanajoven = CodigoGuanajoven::where('token', $token)
            ->first();
        $evento = Evento::find($idEvento);
        $usuario = User::find($codigoGuanajoven->id_usuario);

        $notificacion = $evento->usuarios()->find($usuario->id);

        if (!isset($notificacion) || $notificacion->asistio !== 1) {
            if (isset($codigoGuanajoven)) {
                $usuario = User::find($codigoGuanajoven->id_usuario);

                if (isset($usuario)) {
                    if(!isset($notificacion)) {
                        $evento->usuarios()->attach($usuario->id, ['dispositivo' => 2, 'asistio' => 1]);  
                            
                    } 
                    else {
                        $notificacion->pivot->dispositivo = 2;
                        $notificacion->pivot->asistio = 1;
                        $notificacion->pivot->save();
                    }
                        $puntaje = $usuario->puntaje;
                        $sumaPuntajes = $puntaje + $evento->puntos_otorgados;
                        $usuario->update(['puntaje' => $sumaPuntajes]);
                }
                else {
                    return response()->json(array(
                        'status' => 404,
                        'success' => false,
                        'errors' => ["No existe usuario"],
                        'data' => ''
                    ));
                }

                return response()->json(array(
                    'status' => 200,
                    'success' => true,
                    'errors' => [],
                    'data' => $usuario->email
                ));
                 
            } else {
                return response()->json(array(
                    'status' => 404,
                    'success' => false,
                    'errors' => ["No existe código"],
                    'data' => ''
                ));
            }
        } else {
            return response()->json(array(
                'status' => 404,
                'success' => false,
                'errors' => ["Usuario ya había sido registrado"],
                'data' => ''
            ));
        }
    }

    public function usuariosRegistrados(Request $request)
    {
        $id_evento = $request->input("id_evento");

        $eventos = NotificacionEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 1)
            ->get();

        if ($eventos != null) {

            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();
                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->get();
                $id_guanajoven = CodigoGuanajoven::where('id_usuario', '=', $usuario->id)->first();

                $usuario->nombre = $datos_usuario[0]->nombre;
                $usuario->apellido_paterno = $datos_usuario[0]->apellido_paterno;
                $usuario->apellido_materno = $datos_usuario[0]->apellido_materno;
                $usuario->ruta_imagen = $datos_usuario[0]->ruta_imagen;
                $usuario->id_guanajoven = $id_guanajoven->id_codigo_guanajoven;


                unset($usuario->id);
                unset($usuario->admin);
                unset($usuario->api_token);
                unset($usuario->created_at);
                unset($usuario->updated_at);
                unset($usuario->deleted_at);
                unset($usuario->puntaje);

                array_push($usuarios, $usuario);
            }

            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => $usuarios
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => null
            ));
        }

    }

    public function usuariosInteresados(Request $request)
    {
        $id_evento = $request->input("id_evento");

        $eventos = NotificacionEvento::where('id_evento', '=', $id_evento)
            ->where('asistio', '=', 0)
            ->where('le_interesa', '=', 1)
            ->get();

        if ($eventos != null) {

            $usuarios = array();

            foreach ($eventos as $evento) {
                $usuario = User::where('id', '=', $evento->id_usuario)->first();

                $datos_usuario = DatosUsuario::where('id_usuario', '=', $usuario->id)->get();
                $id_guanajoven = CodigoGuanajoven::where('id_usuario', '=', $usuario->id)->first();


                $usuario->nombre = $datos_usuario[0]->nombre;
                $usuario->apellido_paterno = $datos_usuario[0]->apellido_paterno;
                $usuario->apellido_materno = $datos_usuario[0]->apellido_materno;
                $usuario->ruta_imagen = $datos_usuario[0]->ruta_imagen;
                $usuario->id_guanajoven = $id_guanajoven->id_codigo_guanajoven;

                unset($usuario->id);
                unset($usuario->admin);
                unset($usuario->api_token);
                unset($usuario->created_at);
                unset($usuario->updated_at);
                unset($usuario->deleted_at);
                unset($usuario->puntaje);

                array_push($usuarios, $usuario);
            }

            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => $usuarios
            ));
        } else {
            return response()->json(array(
                'status' => 200,
                'success' => true,
                'errors' => [],
                'data' => null
            ));
        }
    }


    /**
     * Evento: Enviar notificacion
     * params: [api_token, id_evento]
     * Se llama cuando un usuario se interesa en un evento nuevo
     * @param Request $request
     * @return Response
     */
    public function enviarNotificacion(Request $request) {
        $apiToken = $request->api_token;
        $idEvento = $request->id_evento;
        $evento = Evento::find($idEvento);
        $usuario = Auth::guard('api')->user();
        
        if ($evento->usuarios()->find($usuario->id)) {
            return response()->json(array(
                "success" => false,
                "status" => 500,
                "errors" => ["El usuario ya se registró en este evento."]
            ));
        } else {
            $datosUsuario = DatosUsuario::where('id_usuario', $usuario->id)->first();
            $usuario->notify(new EventoNotificacion($evento, $datosUsuario));
            return response()->json(array(
                "success" => true,
                "status" => 200,
                "errors" => [],
                "data" => $evento
            ));
        }
        
    }


    private function subir() {

    }



}
