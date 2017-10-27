<?php

namespace App\Http\Controllers;


use App\CodigoGuanajoven;
use App\Estado;
use App\DatosUsuario;
use App\Genero;
//use App\Http\Controllers\Auth\ImageController;
use App\Http\Controllers\ImageController;
use App\Municipio;
use App\Soap\ConsultaPorCurp;
use App\Soap\ConsultaPorCurpResponse;
use App\User;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Illuminate\Support\Facades\DB;

class UserApiController extends Controller {
    use AuthenticatesUsers;

    protected $soapWrapper;


    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }

    /**
     * Usuario: Registrar
     * params: [curp*, email, password*, confirmar_password*, nombre*, apellido_paterno*, apellido_materno*, genero*,
     * codigo_postal*, fecha_nacimiento*, estado_nacimiento, ruta_imagen, id_google, id_facebook].
     * Método que sirve para registrar usuarios.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function registrar(Request $request) {
        $errors = [];
        $data = null;

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'genero' => 'required|string',
            'codigo_postal' => 'required|integer',
            'fecha_nacimiento' => 'required|string',
            'estado_nacimiento' => 'required|string',
            'curp' => 'required|string|unique:datos_usuario'
        ];

        $input = [
            'curp' => $request->input("curp"),
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'password_confirmation' => $request->input("confirmar_password"),
            'nombre' => $request->input("nombre"),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'genero' => $request->input("genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'fecha_nacimiento' => $request->input("fecha_nacimiento"),
            'estado_nacimiento' => $request->input("estado_nacimiento")
        ];
        $validacion = Validator::make($input, $reglas);

        if ($validacion->fails()) {
            foreach ($validacion->errors()->all() as $error) {
                array_push($errors, $error);
            }
        } else {

            $curp = $request->input('curp');
            $response = $this->calcularCurp($curp);
            if(isset($response['statusOper'])) {

            $id_estado = "";
            $id_municipio = "";
            $codigo_postal = $request->input("codigo_postal");
            $objeto = $this->obtenerEstadoMunicipio($codigo_postal);
            if ($objeto){
            list($id_estado, $id_municipio) = explode(",", $objeto);

            //User
            $correo = $request->input("email");
            $password = $request->input("password");
            $id_google = $request->input("id_google");
            $id_facebook = $request->input("id_facebook");

            $usuario = User::create([
                'email' => $correo,
                'password' => $password,
                'id_google' => $id_google,
                'id_facebook' => $id_facebook
            ]);

            //Datos User
            $id = $usuario->id;
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $genero = $request->input("genero");
            $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->input("fecha_nacimiento"))->toDateString();
            $estado_nacimiento = $request->input("estado_nacimiento");
          //  $id_ocupacion = $request->input("id_ocupacion");
            $telefono = $request->input("telefono");



            if ($id_estado || $id_municipio) {
                $genero = $request->input("genero");
                $id_genero = $this->revisarGenero($genero);
                $id_estado_nacimiento = $this->consultaEstado($estado_nacimiento);


                    $ruta_imagen = "";
                    $datos = $request->input('ruta_imagen');
                    if (isset($datos)) {
                        $ruta = "storage/usuarios/";
                        $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
                    }

                    $datosUsuario = DatosUsuario::create([
                        'id_usuario' => $id,
                        'nombre' => $nombre,
                        'apellido_paterno' => $apellido_paterno,
                        'apellido_materno' => $apellido_materno,
                        'id_genero' => $id_genero,
                        'fecha_nacimiento' => $fecha_nacimiento,
                        'id_estado_nacimiento' => $id_estado_nacimiento,
                        //'id_ocupacion' => $id_ocupacion,
                        'codigo_postal' => $codigo_postal,
                        'telefono' => $telefono,
                        'curp' => $curp,
                        'id_estado' => $id_estado,
                        'id_municipio' => $id_municipio,
                        'ruta_imagen' => $ruta_imagen
                    ]);

                    $fechaLimite = Carbon::createFromFormat('d/m/Y', $request->input("fecha_nacimiento"));
                    $fechaLimite->year = $fechaLimite->year + 30;

                    $codigo_guanajoven = CodigoGuanajoven::create([
                        'id_usuario' => $id,
                        'token' => str_random(128),
                        'fecha_expiracion' => Carbon::now('America/Mexico_City')->addDay(),
                        'fecha_limite' => $fechaLimite
                    ]);
                    if (isset($usuario) && isset($datosUsuario)) {
                        $data =User::
                            with('datosUsuario')
                            ->with('codigoGuanajoven')
                            ->find($usuario->id);
                    } else {
                        array_push($errors, "¡Ops!, parece que algo salió mal. Verifíca que todos tus datos sean correctos.");
                    }

            }


        } else {
            array_push($errors, "No se pudo verificar tu código postal. Por favor verifica que es correcto.");
        }
    }
           else {
               $errors[] = "El CURP Proporcionado no se encuentra registrado.";
           }
        }

        if (count($errors) > 0) {
            return response()->json([
                "success" => false,
                "errors" => $errors,
                "status" => 500,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => true,
                "errors" => $errors,
                "status" => 200,
                "data" => $data
            ]);
        }
    }


    /**
     * Usuario: Actualizar
     * params: [nombre*, id_genero*, codigo_postal*, apellido_paterno*, curp*, estado_nacimiento*, fecha_nacimiento,
     * estado_nacimiento, id_ocupacion, telefono, id_estado, id_municipio].
     * Función que permite la actualización de datos de un usuario, la información principal no puede ser modificada.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function actualizar(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];


        $id_ocupacion = $request->input("id_ocupacion");
        $codigo_postal = $request->input("codigo_postal");
        $telefono = $request->input("telefono");
        $id_estado = $request->input("id_estado");
        $id_municipio = $request->input("id_municipio");

        $datosUsuario = DatosUsuario::where("id", $usuario->id)->first();

        //Imagen
        $ruta_imagen = '';
        ImageController::eliminarImagen($datosUsuario->ruta_imagen);
        $datos = $request->input('ruta_imagen');
        if (isset($datos)) {
            $ruta = "storage/usuarios/";
            $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
        }

        $actualiza = $usuario->datosUsuario
            ->update([
                'id_ocupacion' => $id_ocupacion,
                'codigo_postal' => $codigo_postal,
                'telefono' => $telefono,
                'id_estado' => $id_estado,
                'id_municipio' => $id_municipio,
                'ruta_imagen' => $ruta_imagen
            ]);

        if (isset($actualiza)) {
            $data = [
                "id" => $usuario->id,
                "email" => $usuario->email,
                "api_token" => $usuario->api_token,
                "id_datos_usuario" => $datosUsuario->id_datos_usuario,
                "nombre" => $datosUsuario->nombre,
                "apellido_paterno" => $datosUsuario->apellido_paterno,
                "apellido_materno" => $datosUsuario->apellido_materno,
                "id_genero" => $datosUsuario->id_genero,
                "fecha_nacimiento" => $datosUsuario->fecha_nacimiento,
                "id_estado_nacimiento" => $datosUsuario->id_estado_nacimiento,
                "id_ocupacion" => $datosUsuario->id_ocupacion,
                "codigo_postal" => $datosUsuario->codigo_postal,
                "telefono" => $datosUsuario->telefono,
                "curp" => $datosUsuario->curp,
                "id_estado" => $datosUsuario->id_estado,
                "id_municipio" => $datosUsuario->id_municipio,
                "ruta_imagen" => $datosUsuario->ruta_imagen
            ];
        } else {
            array_push($errors, "Hubo un error con los datos. Verifíca tu información");
        }


        if (count($errors) == 0) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => $data
            ]);
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["¡Ops!, surgió un error en la actualización. Verifíca tus datos"],
                "status" => 500,
                "data" => $data
            ]);
        }
    }

    /**
     * Usuario: Consultar estado.
     * params: [abreviatura].
     * Consulta un estado de la Base de datos a partir de su abreviatura.
     * @param $abreviatura
     * @return bool
     */
    private function consultaEstado($abreviatura) {
        $estado = Estado::where("abreviatura", $abreviatura)->first();
        if (isset($estado)) return $estado->id_estado;
        else return false;
    }

    /**
     * Usuario: Obtener estado y municipio
     * params: [codigo_postal].
     * Se realiza una solicitud para obtener información de municipio y estado a partir de su código postal, los datos
     * obtenidos se utilizan para realizar un registro de usuario en la bd.
     * @param $codigo_postal
     * @return bool|string
     */
    private function obtenerEstadoMunicipio($codigo_postal) {
        $cliente = new Client();
        $respuesta = $cliente->request('GET', 'https://api-codigos-postales.herokuapp.com/v2/codigo_postal/' . $codigo_postal);

        $datos = json_decode($respuesta->getBody());

        $estado = Estado::where("nombre", $datos->estado)->first();
        $municipio = Municipio::where("nombre", $datos->municipio)->first();

        if (isset($estado) && isset($municipio)) return $estado->id_estado . "," . $municipio->id_municipio;
        else return false;
    }

    /* Función que devuelve el id_genero mediante su abreviatura */
    private function revisarGenero($genero) {
        $objetoGenero = Genero::where("abreviatura", $genero)->first();
        if (isset($objetoGenero)) return $objetoGenero->id_genero;
        else return false;
    }

    /**
     * Usuario: Verificar Email
     * params: [email]
     * Método que revisa la existencia de un email registrado en la base de datos.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarEmail(Request $request) {
        $correo = User::where("email", $request->email)->first();
        if (isset($correo)) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => true
            ]);
        } else {
            return response()->json([
                "success" => true,
                "errors" => ["Correo no encontrado"],
                "status" => 200,
                "data" => false
            ]);
        }
    }


    /**
     * Private: Calcular CURP
     * Método privado que permite obtener los datos de CURP a partir de este. Este método no se encuentra expuesto en
     * la API pública y solo es para uso interno.
     * @param $curp
     * @return array
     */
    private function calcularCurp($curp) {
        $this->soapWrapper->add('ConsultaCurp', function ($service) {
            $service
                ->wsdl('http://187.216.144.153:8080/WSCurp/ConsultaCurp.asmx?WSDL')
                ->trace(true)
                ->classmap([
                    ConsultaPorCurp::class,
                    ConsultaPorCurpResponse::class
                ]);
        });

        $response = $this->soapWrapper
            ->call('ConsultaCurp.ConsultaPorCurp', [
                new ConsultaPorCurp($curp)
            ]);
       return (array)$response->getConsultaPorCurpResult();
    }


    /**
     * Usuario: Obtener CURP
     * params: [curp].
     * Método público para la obtención de datos pasando como parámetro un CURP válido.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function obtenerCurp(Request $request) {
        $curp = $request->curp;
        $response = $this->calcularCurp($curp);

        return response()->json(array(
            'success' => true,
            'status' => 200,
            'errors' => [],
            'data' => $response
        ));
    }




    /**
     * public: getPosition
     * Método que devuelve la posición del usuario
     * @param api_token
     * @return posicion
     */
    public function obtenerPosicion(Request $request) {
         $usuario =  Auth::guard('api')->user();
          $data = null;
          $errors = [];
          $position = 1;
          $users = DB::table('usuario')
                ->orderBy('puntaje', 'desc')
                ->get();
      foreach($users as $item  ){
        if($item->email == $usuario->email){
          break;
        }
        $position++;
      }
      return response()->json(array(
          'success' => true,
          'status' => 200,
          'errors' => [],
          'data' => $position
      ));
    }

    public function actualizarTokenGuanajoven(Request $request) {
        $user = Auth::guard('api')->user();
        $success = true;
        $errors = [];
        if($user->codigoGuanajoven->fecha_limite->gt(Carbon::now('America/Mexico_City'))) {
            $user->codigoGuanajoven->token = str_random(128);
            $user->codigoGuanajoven->fecha_expiracion = Carbon::now('America/Mexico_City')->addDay(30);
            $user->codigoGuanajoven->save();
            //$token = $user->codigoGuanajoven->id_codigo_guanajoven."-".$user->datosUsuario->curp."-".$user->datosUsuario->nombre."-".$user->email;
            $token =  $user->codigoGuanajoven->token;
        }
        else {
            $token = null;
            $success = false;
            $errors[] = "El token de código joven no se pudo actualizar";
        }


        return response()->json(array(
            'data' => $token,
            'success' => $success,
            'status' => 200,
            'errors' => $errors
        ));
    }

    /**
     * Devuelve los permisos apartir de un rol
     */
    public function obtenerPermisos(Request $request) {
        $id_rol = $request->id_rol;

        $rol_permiso = DB::table('rol_pemriso')->where('id_rol', '=', $id_rol);

        return response()-json($rol_permiso);
    }
}
