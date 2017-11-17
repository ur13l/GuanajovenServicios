<?php

namespace App\Http\Controllers;


use App\Evento;
use App\NotificacionEvento;
use App\TipoEvento;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Mail;

class EventosController extends Controller {

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        //$this->middleware('auth.web');
    }

    public $meses = [
        'enero' => '01',
        'febrero' => '02',
        'marzo' => '03',
        'abril' => '04',
        'mayo' => '05',
        'junio' => '06',
        'julio' => '07',
        'agosto' => '08',
        'septiembre' => '09',
        'octubre' => '10',
        'noviembre' => '11',
        'diciembre' => '12',
    ];

    /**
     * Función que retorna la vista de inicio con los eventos próximos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $eventos = Evento::proximos()->paginate(10);

        return view('eventos.index', ['eventos' => $eventos]);
    }

    /**
     * Función que muestra la vista para un nuevo evento
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nuevo() {
        $tipos = TipoEvento::all();

        $evento = new Evento();

        $evento->titulo = '';
        $evento->descripcion = '';
        $evento->fecha_inicio = Carbon::now();
        $evento->fecha_fin = Carbon::tomorrow();
        $evento->id_tipo_evento = 1;
        $evento->latitud = 0;
        $evento->longitud = 0;
        $evento->direccion = '';
        $evento->puntos_otorgados = 0;
        $evento->area_responsable = '';

        return view('eventos.nuevo', [
            'tipos' => $tipos,
            'evento' => $evento,
            'fecha_inicio' => '',
            'fecha_fin' => '',
            'hora_inicio' => '',
            'hora_fin' => '',
            'latitud' => 21.095570,
            'longitud' => -101.616843,
            'accion' => 'nuevo'
        ]);
    }

    /**
     * Función para guardar un nuevo evento
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function guardar(Request $request) {
        $idEvento = $request->input('id_evento');
        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $accion = $request->input('accion');
        $fechaI = $request->input('fecha_inicio');
        $fechaF = $request->input('fecha_fin');
        $horaI = $request->input('hora_inicio');
        $horaF = $request->input('hora_fin');
        $direccion = null;
        $tipoEvento = $request->input('tipo-evento');
        $posicion = explode(', ', $request->input('posicion'));
        $puntos = $request->input('puntos-otorgados');
        $area = $request->input('area-responsable');

        //Obtener latitud y longitud
        $latitud = explode('(', $posicion[0])[1];
        $longitud = explode(')', $posicion[1])[0];

        //Petición a Google para obtener la dirección a partir de latitud y longitud
        $client = new Client();
        $resource = $client->get('https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $latitud . ',' . $longitud . '&sensor=true');
        $resultado = json_decode($resource->getBody());
        if(count($resultado->results) > 0) {
            $direccion = $resultado->results[0]->formatted_address;
        }
        $fechaInicio = $fechaI . " " . $horaI;
        $fechaFin = $fechaF . " " . $horaF;


            //Formatear fechas con horas
            $fechaI = explode(' ', $fechaI);
            $horaI = explode(':', $horaI);
            $anioI = $fechaI[2];
            $mesI = rtrim($fechaI[1], ',');
            $mesI = $this->meses[strtolower($mesI)];
            $diaI = $fechaI[0];
            $horaIn = $horaI[0];
            $MinIn = $horaI[1];

            $fechaF = explode(' ', $fechaF);
            $horaF = explode(':', $horaF);
            $anioF = $fechaF[2];
            $mesF = rtrim($fechaF[1], ',');
            $mesF = $this->meses[strtolower($mesF)];
            $diaF = $fechaF[0];
            $horaFn = $horaF[0];
            $MinFn = $horaF[1];

            $fechaInicio = Carbon::create($anioI, $mesI, $diaI, $horaIn, $MinIn, 0);
            $fechaFin = Carbon::create($anioF, $mesF, $diaF, $horaFn, $MinFn, 0);


        //Guardar evento
        if(isset($idEvento)) {
            $evento = Evento::find($idEvento);
        }
        else {
            $evento = new Evento();
        }

        $evento->titulo = $titulo;
        $evento->descripcion = $descripcion;
        $evento->fecha_inicio = $fechaInicio;
        $evento->fecha_fin = $fechaFin;
        $evento->id_tipo_evento = $tipoEvento;
        $evento->latitud = $latitud;
        $evento->longitud = $longitud;
        $evento->direccion = $direccion;
        $evento->puntos_otorgados = $puntos;
        $evento->area_responsable = $area;

        try {
            $evento->save();
            return redirect()->to('/eventos/inicio');
        } catch(\Exception $ex) {
            $tipos = TipoEvento::all();

            return view('eventos.nuevo', ['tipos' => $tipos, 'mensaje' => 'Ocurrió un error al guardar el evento']);
        }
    }

    /**
     * Función para la edición de los detalles de un evento
     * @param $idEvento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editar($idEvento) {
        $evento = Evento::find($idEvento);
        $tipos = TipoEvento::all();
        list($fechaInicio, $horaInicio) = explode(' ', $evento->fecha_inicio);
        list($fechaFin, $horaFin) = explode(' ', $evento->fecha_fin);

        return view('eventos.editar', [
            'tipos' => $tipos,
            'evento' => $evento,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'latitud' => $evento->latitud,
            'longitud' => $evento->longitud,
            'accion' => 'editar'
        ]);
    }

    public function eliminar(Request $request) {
        $idEvento = $request->input('idEvento');
        $evento = Evento::find($idEvento);
        $evento->delete();
        return  redirect()->route('eventos');
    }

    public function estadistica($idEvento) {
        $evento = Evento::find($idEvento);
        $asistentes = NotificacionEvento::where('id_evento', $evento->id_evento)->get();

        if (isset($asistentes)) {
            $usuariosAsistentes = [];

            foreach ($asistentes as $asistente) {
                $usuario = User::find($asistente->id_usuario);

                if (isset($usuario)) {
                    if ($asistente->asistio == 1) {
                        //Calcular edad
                        $fecha_nacimiento = $usuario->datosUsuario->fecha_nacimiento->toDateTimeString();
                        $fecha_nacimiento = date('d/m/Y', strtotime($fecha_nacimiento));
                        $fecha_nacimiento = explode('/', $fecha_nacimiento);

                        $edad = (date("md", date("U", mktime(0, 0, 0, $fecha_nacimiento[0], $fecha_nacimiento[1], $fecha_nacimiento[2]))) > date("md")
                                ? ((date("Y") - $fecha_nacimiento[2]) - 1)
                                : (date("Y") - $fecha_nacimiento[2]));
                        $usuario->setAttribute('edad', $edad);

                        array_push($usuariosAsistentes, $usuario);
                    }
                }
            }
        } else {
            $usuariosAsistentes = [];
        }

        return view('eventos.estadistica', [
            'evento' => $evento,
            'usuariosAsistentes' => $usuariosAsistentes,
        ]);
    }

     //En caso de ser un email de Eventos
     public function registrado(Request $request) {
        $id_usuario = $request->id_usuario;
        $idEvento = $request->id_evento;
        $curp_usuario = $request->curp_usuario;
        $nombreEvento = $request->nombre_evento;
        $evento = Evento::find($idEvento);
        $usuario = User::find($id_usuario);
        if ($evento->usuarios->contains($usuario)) {
            return view('layout.usuario_listo', ['titulo' => $nombreEvento]);
        } else {
             return $this->enviarCorreoEvento($id_usuario, $idEvento, $curp_usuario, $nombreEvento);
        }
    }


    public function enviarCorreoEvento($idUsuario, $idEvento, $curp, $nombreEvento) {
        $usuario = User::find($idUsuario);
        $evento = Evento::find($idEvento);
        $evento->usuarios()->attach($usuario->id, ['le_interesa' => 1]);

        Mail::send('correos.notificacion_enviada', [
            'curp_usuario' => $curp,
            'tipo' => 'el evento',
            'titulo' => $nombreEvento
        ], function ($message) use ($curp, $nombreEvento, $usuario) {
            //Desde donde llega el mensaje
            $message->from('guanajoven@gmail.com', 'Guanajoven');
            //Mensaje para el usuario
            $message->to( $usuario->email, 'Administrador')
                    ->subject('Nuevo registro al evento: '.$nombreEvento);
        });

        return view('layout.usuario_registrado', ['titulo' => $nombreEvento]);
    }
}
