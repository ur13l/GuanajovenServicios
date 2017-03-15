<?php

namespace App\Http\Controllers;


use App\Estado;
use App\DatosUsuario;
use App\Http\Controllers\Auth\ImageController;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;

class UserApiController extends Controller {
    use AuthenticatesUsers;

    function registrar(Request $request) {
        $errors = [];
        $data = null;

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'genero' => 'required|string',
            'codigo_postal' => 'required|integer|',
            'fecha_nacimiento' => 'required|string',
            'estado_nacimiento' => 'required|string'
        ];
        $input = [
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
            //Usuario
            $correo = $request->input("email");
            $password = $request->input("password");

            $usuario = Usuario::create([
                'email' => $correo,
                'password' => $password,
            ]);

            //Datos Usuario
            $ruta_imagen = "";
            $id_estado = "";
            $curp = "";
            $id = $usuario->id;
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $id_genero = $request->input("id_genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $id_estado_nacimiento = $request->input("estado_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $codigo_postal = $request->input("codigo_postal");
            $telefono = $request->input("telefono");
            $id_municipio = $request->input("id_municipio");



            $abre_estado = $request->input("id_estado");
            if (isset($abre_estado)) {
                $id_estado = $this->consultaEstado($abre_estado);
            }

            $datos = $request->input('ruta_imagen');
            if (isset($datos)) {
                $ruta = "storage/usuarios/";
                $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
            }

            $datosUsuario = DatosUsuario::create([
                'id' => $id,
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'id_genero' => $id_genero,
                'fecha_nacimiento' => $fecha_nacimiento,
                'id_estado_nacimiento' => $id_estado_nacimiento,
                'id_ocupacion' => $id_ocupacion,
                'codigo_postal' => $codigo_postal,
                'telefono' => $telefono,
                'curp' => $curp,
                'id_estado' => $id_estado,
                'id_municipio' => $id_municipio,
                'ruta_imagen' => $ruta_imagen
            ]);

            if (isset($usuario) && isset($datosUsuario)) {
                $data = [
                    "id" => $usuario->id,
                    "correo" => $usuario->email,
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
                array_push($errors, "¡Ops!, parece que algo salió mal. Verifíca que todos tus datos sean correctos.");
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

    /* Función para actualizar los datos de un usuario */
    function actualizar(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];

        $reglas = [
            'nombre' => 'required|string',
            'id_genero' => 'required|integer',
            'codigo_postal' => 'required|integer|',
            'apellido_paterno' => 'required|string',
            'curp' => 'required|string',
            'estado_nacimiento' => 'required|string'
        ];
        $input = [
            'nombre' => $request->input("nombre"),
            'id_genero' => $request->input("id_genero"),
            'codigo_postal' => $request->input("codigo_postal"),
            'apellido_paterno' => $request->input('apellido_paterno'),
            'curp' => $request->input("curp"),
            'estado_nacimiento' => $request->input("estado_nacimiento")
        ];
        $validacion = Validator::make($input, $reglas);

        if ($validacion->fails()) {
            foreach ($validacion->errors()->all() as $error) {
                array_push($errors, $error);
            }
        } else {
            //Datos Usuario
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $id_genero = $request->input("id_genero");
            $fecha_nacimiento = $request->input("fecha_nacimiento");
            $id_estado_nacimiento = $request->input("estado_nacimiento");
            $id_ocupacion = $request->input("id_ocupacion");
            $codigo_postal = $request->input("codigo_postal");
            $telefono = $request->input("telefono");
            $curp = $request->input("curp");
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

            $actualiza = DatosUsuario::where("id", $usuario->id)
                ->update([
                    'nombre' => $nombre,
                    "apellido_paterno" => $apellido_paterno,
                    "apellido_materno" => $apellido_materno,
                    'id_genero' => $id_genero,
                    'fecha_nacimiento' => $fecha_nacimiento,
                    'id_estado_nacimiento' => $id_estado_nacimiento,
                    'id_ocupacion' => $id_ocupacion,
                    'codigo_postal' => $codigo_postal,
                    'telefono' => $telefono,
                    'curp' => $curp,
                    'id_estado' => $id_estado,
                    'id_municipio' => $id_municipio,
                    'ruta_imagen' => $ruta_imagen
                ]);

            if (isset($actualiza)) {
                $data = [
                    "id" => $usuario->id,
                    "correo" => $usuario->email,
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

    /* Función para obtener el id_estado mediante su abreviatura */
    private function consultaEstado($abreviatura) {
        $id_estado = Estado::where("abreviatura", $abreviatura)->first();
        return $id_estado->id_estado;
    }

    /* Función para calcular CURP mediante los datos personales */
    private  function calcularCurp($nombre, $ap_paterno, $ap_materno, $fecha_nac, $estado, $genero) {
        /*
          Primera letra y primera vocal del primer apellido
          Primer letra del segundo apellido
          Primera letra del nombre, si el primer nombre es Jose/Maria, se tomara el segundo nombre si lo tiene
          Fecha de nacimiento (ultimos dos dígitos del año, mes y día)
         * Sexo (se usara la letra H o M)
         * Dos letras correspondientes al estado de nacimiento, si es extranjero se usa NE
         * Primera consonante interna del segundo apellido
         * Primer consonante interna del nombre
         * Dos digitos para evitar duplicaciones
        */

        $vocales = ["A", "E", "I", "O", "U"];

        $primer_letra = $ap_paterno{0};
        for ($j = count($ap_paterno); $j > 0; $j++) {
            for ($i = 0; $i < count($vocales); $i++) {
                if ($ap_paterno{$j}.equalToIgnoringCase($vocales{$i})) $segunda_letra = "";
                else $segunda_letra = $ap_paterno{$j};
            }
        }

        $tercer_letra = $ap_materno{0};
        list($primer_nombre, $segundo_nombre) = explode(' ', $nombre);
        if ($primer_nombre.equalToIgnoringCase("Jose") || $primer_nombre.equalToIgnoringCase("Maria")) $cuarta_letra = $segundo_nombre{0};
        else $cuarta_letra = $primer_nombre{0};

        list($dia, $mes, $anio) = explode('/', $fecha_nac);
        $fecha = $anio{2} . $anio{3} . $mes . $dia;


    }
}