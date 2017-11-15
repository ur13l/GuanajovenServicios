<?php

namespace App\Http\Controllers;

use App\DatosUsuario;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Illuminate\Support\Facades\DB;

class ProfileApiController extends Controller {
    use AuthenticatesUsers;

    protected $soapWrapper;


    public function __construct(SoapWrapper $soapWrapper) {
        $this->soapWrapper = $soapWrapper;
    }


    /**
     * Perfil: Actualizar
     * params: [id_nivel_estudios*, id_pueblo_indigena*, id_capacidad_diferente*, premios*, proyectos_sociales*, apoyo_proyectos_sociales*,
     * api_token].
     * Función que actualiza el perfil del usuario.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function updateProfile(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];


        $id_nivel_estudios = $request->input("id_nivel_estudios");
        $id_pueblo_indigena = $request->input("id_pueblo_indigena");
        $id_capacidad_diferente = $request->input("id_capacidad_diferente");
        $premios = $request->input("premios");
        $proyectos_sociales = $request->input("proyectos_sociales");
        $apoyo_proyectos_sociales = $request->input("apoyo_proyectos_sociales");
        $id_programa_beneficiario = $request->input("id_programa_beneficiario");
        $trabaja = $request->input("trabaja");
        $idiomas = $request->input("idiomas");
        //$idiomas = \GuzzleHttp\json_decode($request->input('idiomas'));
      //  dd($idiomas[0]["id_datos_usuario"]);
      //  $conversacion = $request->input("conversacion");
      //  $lectura = $request->input("lectura");
      //  $escritura = $request->input("escritura");


        $datosUsuario = DatosUsuario::where("id_usuario", $usuario->id)->first();

        $ruta_imagen = "";
        $datos = $request->input('ruta_imagen');
        if (isset($datos)) {
            $ruta = "storage/usuarios/";
            $ruta_imagen = url(ImageController::guardarImagen($datos, $ruta, uniqid("usuario_")));
        }

        $actualiza = $usuario->datosUsuario
            ->update([
                'ruta_imagen' => $ruta_imagen,
                'id_nivel_estudios' => $id_nivel_estudios,
                'id_pueblo_indigena' => $id_pueblo_indigena,
                'id_capacidad_diferente' => $id_capacidad_diferente,
                'premios' => $premios,
                'proyectos_sociales' => $proyectos_sociales,
                'apoyo_proyectos_sociales' => $apoyo_proyectos_sociales,
                'id_programa_beneficiario' => $id_programa_beneficiario,
                'trabaja' => $trabaja
            ]);


          /*  foreach($idiomas as $idioma){
              foreach($datosUsuario->idiomasAdicionales as $idiomaadicional){
                   if($idiomaadicional->id_idioma_adicional == $idioma["id_idioma_adicional"]){
                      $idiomaadicional->pivot->conversacion  = $idioma["conversacion"];
                      $idiomaadicional->pivot->lectura  = $idioma["lectura"];
                      $idiomaadicional->pivot->escritura  = $idioma["escritura"];
                      $idiomaadicional->pivot->save();
                    }else{
                    //  $datosUsuario->idiomasAdicionales()->attach($idioma);
                    dd($idioma);
                    $datosUsuario->idiomasAdicionales()->attach($idioma)*/

         DB::table('datos_usuario_idioma')->where('id_datos_usuario', '=', $datosUsuario->id_datos_usuario)->delete();
          //  $review->product()->detach()
        if (count($datosUsuario->idiomasAdicionales) == 0){
        foreach ( $idiomas  as $idioma ){
          $idioma["id_datos_usuario"] = $datosUsuario->id_datos_usuario;
        }
         $datosUsuario->idiomasAdicionales()->attach($idiomas);
      }

        if (isset($actualiza)) {
        } else {
            array_push($errors, "Hubo un error con los datos.");
        }


        if (count($errors) == 0) {
            return response()->json([
                "success" => true,
                "errors" => [],
                "status" => 200,
                "data" => false
            ]);

        } else {
            return response()->json([
                "success" => false,
                "errors" => ["¡Ops!, surgió un error en la actualización. Verifica tus datos"],
                "status" => 500,
                "data" => false
            ]);
        }
    }



    /**
     * Perfil: Devuelve información
     * params: [] api_token].
     * Función que devuelve el perfil del usuario.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function getProfile(Request $request) {
        $usuario =  Auth::guard('api')->user();
        $data = null;
        $errors = [];
      
          if (isset($datosUsuario)) {
            $data = [
                "ruta_imagen" => $datosUsuario->ruta_imagen,
                "id_nivel_estudios" => $datosUsuario->id_nivel_estudios,
                "id_pueblo_indigena" => $datosUsuario->id_pueblo_indigena,
                "id_capacidad_diferente" => $datosUsuario->id_capacidad_diferente,
                "premios" => $datosUsuario->premios,
                "proyectos_sociales" => $datosUsuario->proyectos_sociales,
                "apoyo_proyectos_sociales" => $datosUsuario->apoyo_proyectos_sociales,
                "id_programa_beneficiario" => $datosUsuario->id_programa_beneficiario,
                "trabaja" => $datosUsuario->trabaja,
                "idiomas" => $idiomas
            ];
          } else {
            array_push($errors, "Hubo un error con los datos.");
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
                "errors" => ["¡Ops!, surgió un error en la actualización. Verifica tus datos"],
                "status" => 500,
                "data" => $data
            ]);
        }
    }
  }
