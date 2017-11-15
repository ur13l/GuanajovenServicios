<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\DatosUsuario;
use Illuminate\Support\Facades\View;
use App\Estado;
use App\Genero;
use App\NivelEstudios;
use App\PuebloIndigena;
use App\CapacidadDiferente;
use App\ProgramaGobierno;
use App\IdiomaAdicional;
use Validator;
use App\Soap\ConsultaPorCurp;
use App\Soap\ConsultaPorCurpResponse;
use Artisaninweb\SoapWrapper\SoapWrapper;
use GuzzleHttp\Client;
use App\Municipio;
use App\CodigoGuanajoven;


class JovenesController extends Controller
{
    protected $soapWrapper;
    
    
        public function __construct(SoapWrapper $soapWrapper) {
            $this->soapWrapper = $soapWrapper;
        }

    public function index(Request $request){
       $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
       ->where('fecha_nacimiento', '>',Carbon::now('America/Mexico_City')->subYears(30) )->paginate(20);

       return view('jovenes.index', ['usuarios' => $usuarios, 'tipo' => 'def', 'columna' => '']);
    }

    public function buscar(Request $request){
      $q = $request->q;
      $columna = $request->columna ?: 'usuario.id';
      $tipo = $request->tipo ?: 'asc';
      $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
        -> leftJoin('municipio', 'datos_usuario.id_municipio', '=', 'municipio.id_municipio')
        -> leftJoin('genero', 'datos_usuario.id_genero', '=', 'genero.id_genero')
        -> leftJoin('codigo_guanajoven', 'usuario.id', '=', 'codigo_guanajoven.id_usuario')
      ->where('fecha_nacimiento', '>',Carbon::now('America/Mexico_City')->subYears(30))
      ->where(function ($query) use ($q){
        $query -> where('id_codigo_guanajoven', 'like', "%$q%")
               -> orWhere('datos_usuario.nombre', 'like', "%$q%")
               -> orWhere('apellido_paterno', 'like', "%$q%")
               -> orWhere('apellido_materno', 'like', "%$q%")
               -> orWhere('curp', 'like', "%$q%")
               -> orWhere('email', 'like', "%$q%")
               -> orWhere('municipio.nombre', 'like', "%$q%")
               -> orWhere('genero.nombre', 'like', "%$q%");
      })
      ->orderBy($columna, $tipo)
      ->paginate(20);      
      
      return View::make('jovenes.lista', ['usuarios' => $usuarios, 'tipo' => $tipo, 'columna' => $columna])->render();      
    }

    public function nuevo() {
      $estados = Estado::all();
      $generos = Genero::all();
      return view('jovenes.nuevo', ['estados'=> $estados, 'generos'=> $generos]);
    }

    function registrar(Request $request) {
        $fecha_nacimiento = Carbon::createFromFormat('d/m/Y', $request->input("fecha_nacimiento"))->toDateString();
        //dd($fecha_nacimiento);        
      $errors = [];

      $reglas = [
          'email' => 'required|email|unique:usuario',
          'password' => 'required|confirmed',
          'nombre' => 'required|string',
          'apellido_paterno' => 'required|string',
          'genero' => 'required|string',
          'codigo_postal' => 'required|integer|',
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

          $id_estado = "";
          $id_municipio = "";
          $codigo_postal = $request->input("codigo_postal");
          if (isset($codigo_postal)) {
              $objeto = $this->obtenerEstadoMunicipio($codigo_postal);
              if ($objeto == false){
                  array_push($errors, "No se pudo verificar tu código postal. Por favor verifica que es correcto.");
              } else {
                  list($id_estado, $id_municipio) = explode(",", $objeto);
              }
          }

          if ($id_estado || $id_municipio) {
              $genero = $request->input("genero");
              $id_genero = "";
              if (isset($genero)) {
                  $id_genero = $this->revisarGenero($genero);

                  if ($id_genero == false) {
                      array_push($errors, "No se pudo validar el genero. Por favor verifica tus datos");
                  } else {
                      $id_estado_nacimiento = "";
                      if (isset($estado_nacimiento)) {
                          $id_estado_nacimiento = $this->consultaEstado($estado_nacimiento);

                          if ($id_estado_nacimiento == false) {
                              array_push($errors, "No se pudo encontrar el estado de nacimiento. Por favor verifica tus datos");
                          } else {
                              $ruta_imagen = "";
                              $datos = $request->file('ruta_imagen');
                              if (isset($datos)) {
                                  $nombre_imagen = uniqid("usuario_").".".$datos->getClientOriginalExtension();
                                  $ruta = "storage/usuarios/";
                                  $ruta_imagen = url($ruta . $nombre_imagen);
                                  $datos->move($ruta, $nombre_imagen);
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
                      }
                  }
              }
          }
         } else {
             $errors[] = "El CURP Proporcionado no se encuentra registrado.";
         }
      }

      if (count($errors) > 0) {
        return redirect()->back()->withErrors($errors);
      } else {
          return redirect('/jovenes/perfil/'.$usuario->id);
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
     * Usuario: Actualizar
     * params: [nombre*, id_genero*, codigo_postal*, apellido_paterno*, curp*, estado_nacimiento*, fecha_nacimiento,
     * estado_nacimiento, id_ocupacion, telefono, id_estado, id_municipio].
     * Función que permite la actualización de datos de un usuario, la información principal no puede ser modificada.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
     function actualizar(Request $request) {
        $usuario =  User::find($request->input("idUsuario"));
        $email = $request->input("email");        
        $usuario->email = $email;
        $usuario->save();
        $data = null;
        $errors = [];
        
        $codigo_postal = $request->input("codigo_postal");
        //$id_estado = $request->input("id_estado");
        //$id_municipio = $request->input("id_municipio");
        $id_nivel_estudios = $request->input("id_nivel_estudios");  
        $id_pueblo_indigena = $request->input("id_pueblo_indigena");
        $id_capacidad_diferente = $request->input("id_capacidad_diferente");
        $proyectos_sociales = $request->input("proyectos_sociales");
        $premios = $request->input("premios");
        $apoyo_proyectos_sociales = $request->input("apoyo_proyectos_sociales");
        $trabaja = $request->input("trabaja");
        $id_programa_beneficiario = $request->input("id_programa_beneficiario");
        $Documentos = $request->input("Documentos");

        $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

        
        $id_idiomas = $request->input('idioma');
        $conversacion = $request->input('conversacion');
        $lectura = $request->input('lectura');
        $escritura = $request->input('escritura');
        $idiomas_nuevos = [];
        $idiomas_viejos = [];
        $idiomas_actuales = $datosUsuario->idiomasAdicionales;
        
        if(count($idiomas_actuales) > 0){
            for($i = 0; $i < count($idiomas_actuales); $i++){
                $idiomas_viejos[] = $idiomas_actuales[$i]->id_idioma_adicional;
            }
            $datosUsuario->idiomasAdicionales()->detach($idiomas_viejos);
        }

        for($i = 0; $i < count($id_idiomas); $i++){
            $idiomas_nuevos[$id_idiomas[$i]] = ['conversacion' => $conversacion[$i], 'lectura' => $lectura[$i], 'escritura' => $escritura[$i]];
        }
        $datosUsuario->idiomasAdicionales()->attach($idiomas_nuevos);

        //Imagen
        $ruta_imagen = '';
        ImageController::eliminarImagen($datosUsuario->ruta_imagen);
        $datos = $request->input('ruta_imagen');
        if (isset($datos)) {
            $ruta = "storage/usuarios/";
            $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
        }

        $id_estado = "";
        $id_municipio = "";
        $codigo_postal = $request->input("codigo_postal");
        if (isset($codigo_postal)) {
            $objeto = $this->obtenerEstadoMunicipio($codigo_postal);
            if ($objeto == false){
                array_push($errors, "No se pudo verificar tu código postal. Por favor verifica que es correcto.");
            } else {
                list($id_estado, $id_municipio) = explode(",", $objeto);
            }
        }

        $actualiza = $usuario->datosUsuario
            ->update([
                
                'id_estado' => $id_estado,
                'id_municipio' => $id_municipio,
                'email' => $email,
                'codigo_postal' => $codigo_postal,
                'id_nivel_estudios' => $id_nivel_estudios,
                'id_pueblo_indigena' => $id_pueblo_indigena,
                'id_capacidad_diferente' => $id_capacidad_diferente,
                'premios' => $premios,
                'proyectos_sociales' => $proyectos_sociales,
                'apoyo_proyectos_sociales' => $apoyo_proyectos_sociales,
                'trabaja' => $trabaja,
                'id_programa_beneficiario' => $id_programa_beneficiario,
                'Documentos' => $Documentos
            ]);

        if (isset($actualiza)) {
            $data = [
                "id" => $usuario->id,
                "email" => $usuario->email,
                'id_nivel_estudios' => $datosUsuario->$id_nivel_estudios,
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
            return redirect('/jovenes');
        } else {
            return response()->json([
                "success" => false,
                "errors" => ["¡Ops!, surgió un error en la actualización. Verifíca tus datos"],
                "status" => 500,
                "data" => $data
            ]);
        }
    }



/*  public function crear(Request $request){
      $this -> validate($request, [
        'email' => 'required',
        'nombre' => 'required',
        'apellido_paterno' => 'required',
        'apellido_materno' => 'required',
        'fecha_nacimiento' => 'required',
        'id_estado_nacimiento' => 'required',
        'curp' => 'required',
        'codigoPostal' => 'required', 
      ]);


      $nombre = $request->input('nombre');
      $apellidoPaterno = $request->input('apellido_paterno');
      $apellidoMaterno = $request->input('apellido_materno');
      $idGenero = $request->input('id_genero');
      $fechaNacimiento = $request->input('fecha_nacimiento');
      $idEstadoNacimiento = $request->input('id_estado_nacimiento');
      $codigoPostal = $request->input('codigo_postal');
      $telefono = $request->input('telefono');
      $curp = $request->input('curp');
      $idEstado = $request->input('id_estado');
      $idNivelEstudios = $request->input('id_nivel_estudios');
      $idPuebloIndigena = $request->input('id_pueblo_indigena');
      $idCapacidadDiferente = $request->input('id_capacidad_diferente');
      $premios = $request->input('premios');
      $proyectosSociales = $request->input('proyectos_sociales');
      $apoyoProyectosSociales = $request->input('apoyo_proyectos_sociales');
      $trabaja = $request->input('trabaja');
      $id_programa_beneficiario = $request->input('id_programa_beneficiario');
      $email = $request->input('email');
      $password = $this->passGenerator();

      $user = User::create(array(
        'email' =>$email,
        'password' =>$password
    ));


      DatosUsuario::create(array(
       'id_usuario' => $user->id,
       'nombre' => $nombre,
       'apellido_paterno' => $apellidoPaterno,
       'apellido_materno' => $apellidoMaterno,
       'id_genero' => $idGenero,
       'fecha_nacimiento' => $fechaNacimiento,
       'id_estado_nacimiento' => $idEstadoNacimiento,
       'codigo_postal' => $codigoPostal,
       'telefono' => $telefono,
       'curp' => $curp,
       'id_estado' => $idEstado,
       'id_nivel_estudios' => $idNivelEstudios,
       'id_pueblo_indigena' => $idPuebloIndigena,
       'id_capacidad_diferente' => $idCapacidadDiferente,
       'premios' => $premios,
       'proyectos_sociales' => $proyectosSociales,
       'apoyo_proyectos_sociales' => $apoyoProyectosSociales,
       'trabaja' => $trabaja,
       'id_programa_beneficiario' => $id_programa_beneficiario
     ));

     $estados = Estado::all();
     return view('jovenes.perfil', ['estados' , $estados]);
     //return redirect()->back();
    }*/

    public function passGenerator(){
      //Se define una cadena de caractares.
      $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
      //Obtenemos la longitud de la cadena de caracteres
      $longitudCadena=strlen($cadena);
      
      //Se define la variable que va a contener la contraseña
      $pass = "";
      //Se define la longitud de la contraseña
      $longitudPass=10;
      
      //Creamos la contraseña
      for($i=1 ; $i<=$longitudPass ; $i++){
          //Definimos número aleatorio entre 0 y la longitud de la cadena de caracteres-1
          $pos=rand(0,$longitudCadena-1);
      
          //Vamos formando la contraseña en cada iteración del bucle, añadiendo a la cadena $pass la letra correspondiente a la posición $pos en la cadena de caracteres definida.
          $pass .= substr($cadena,$pos,1);
      }
      return $pass;

    }
//Método para editar joven seleccionado
      public function editar(){
        return view('jovenes.editar');
      }
   /* public function editar(Request $request){
      $id_usuario = $request->input('id_usuario');  
      $usuario = User::find($id_usuario);
      $usuario->update($request->all());
      header('Location: /Prueba1/public/jovenes');
      die();
    }*/

    public function perfil($id_usuario){
        $estados = Estado::all();
        $municipios = Municipio::all();
        $niveles_estudio = NivelEstudios::all(); 
        $pueblos_indigena = PuebloIndigena::all();  
        $capacidades_diferente = CapacidadDiferente::all(); 
        $programas_gobierno = ProgramaGobierno::all();   
        $idiomas = IdiomaAdicional::all();
        $generos = Genero::all();
        $usuario = User::find($id_usuario);
        $datosUsuario = DatosUsuario::where('id_usuario', $id_usuario)->first();
        $codigo_guanajoven = CodigoGuanajoven::where('id_usuario', $id_usuario)->first();
      return view("jovenes.perfil", ['usuario' => $usuario, 'datosUsuario' => $datosUsuario, 'codigoGuanajoven' => $codigo_guanajoven, 'estados' => $estados, 
                'municipios' => $municipios, 'niveles_estudio' => $niveles_estudio, 'pueblos_indigena' => $pueblos_indigena, 'capacidades_diferente' => $capacidades_diferente,
                'programas_gobierno' => $programas_gobierno, 'idiomas' => $idiomas, 'generos'=> $generos]);

    }

    public function borrar(Request $request){
      $id_usuario = $request->input('id_usuario');
      $usuario = User::find($id_usuario);
      $usuario->delete();
      return redirect()->back();    
    }
}
