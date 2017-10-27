<?php

namespace App\Http\Controllers;

use App\CodigoGuanajoven;
use App\DatosUsuario;
use App\Evento;
use App\NotificacionEvento;
use App\Notifications\EventoNotificacion;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;

class EventoApiController extends Controller
{

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

        //dd($distanciaMetros);


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
            //->where('fecha_limite', '>', $fechaActual)
            //->where('fecha_expiracion', '>', $fechaActual)
            ->first();

        $notificacion_existe = NotificacionEvento::where('id_evento', '=', $idEvento)->where('id_usuario', '=', $codigoGuanajoven->id_usuario)->first();

        if (!isset($notificacion_existe)) {
            if (isset($codigoGuanajoven)) {
                $usuario = User::find($codigoGuanajoven->id_usuario);

                if (isset($usuario)) {
                    $notificacion = NotificacionEvento::where('id_evento', $idEvento)
                        ->where('id_usuario', $usuario->id)
                        ->first();

                    if (isset($notificacion)) {
                        $notificacion->dispositivo = 2;
                        $notificacion->save();
                    } else {
                        NotificacionEvento::create([
                            'id_evento' => $idEvento,
                            'id_usuario' => $usuario->id,
                            'dispositivo' => 2,
                            'asistio' => 1
                        ]);
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
                        'errors' => ["No existe usuario"],
                        'data' => ''
                    ));
                }
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

    private function subir() {

}

}
