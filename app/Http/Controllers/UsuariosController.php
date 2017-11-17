<?php
/**
 * Created by PhpStorm.
 * User: leonardolirabecerra
 * Date: 01/02/17
 * Time: 2:45 PM
 */

namespace App\Http\Controllers;


use App\Area;
use App\Dependencia;
use App\Direccion;
use App\Funcionario;
use App\User;
use App\DatosUsuario;
use App\Permiso;
use App\Puesto;
use App\Rol;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Dir;
use DB;
use Validator;

class UsuariosController extends Controller{

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        $this->middleware('auth.web');
    }

    public function index(Request $request) {
        $usuarios = Funcionario::where('estatus', '=', 1)->paginate(20);

        return view('usuarios.index', ['usuarios' => $usuarios]);
    }

    public function nuevo(Request $request) {
        $roles = Rol::all();
        $permisos = Permiso::all();
        $puestos = Puesto::all();
        $areas = Area::all();
        $direcciones = Direccion::all();
        $dependencias = Dependencia::all();

        return view('usuarios.nuevo',
            ['roles' => $roles, 'permisos' => $permisos, 'puestos' => $puestos,
            'areas' => $areas, 'direcciones' => $direcciones, 'dependencias' => $dependencias]);
    }

    /**
     * Devuelve los permisos apartir de un rol
     */
    public function obtenerPermisos(Request $request) {
        $id_rol = $request->id_rol;

        $roles_permisos = DB::table('rol_permiso')->where('id_rol', '=', $id_rol)->get();

        $permisos = Permiso::all();
        $permisos_rol = array();

        foreach($roles_permisos as $rol_permiso) {
            $permiso = Permiso::where('id', '=', $rol_permiso->id_permiso)->first();
            array_push($permisos_rol, $permiso);
        }

        $data = array('permisos' => $permisos, 'permisos_rol' => $permisos_rol);        

        return $data;
    }

    public function obtenerValoresPuesto(Request $request) {
        $id_puesto = $request->id_puesto;

        $puesto = Puesto::where('id', '=', $id_puesto)->first();
        $area = Area::where('id', '=', $puesto->id_area)->first();
        $direccion = Direccion::where('id', '=', $area->id_direccion)->first();
        $dependencia = Dependencia::where('id', '=', $direccion->id_dependencia)->first();

        $data = array('area' => $area, 'direccion' => $direccion, 'dependencia' => $dependencia);

        return $data;
    }


    /**
     * Usuario: Registrar
     * Método para el registro de un usuario desde admin.
     * @param Request $request
     * @return Response
     */
    public function registrar(Request $request) {
        $errors = [];
        $data = null;

        $reglas = [
            'email' => 'required|email|unique:usuario',
            'password' => 'required|confirmed',
            'nombre' => 'required|string',
            'apellido_paterno' => 'required|string',
            'curp' => 'required|string|unique:datos_usuario'
        ];

        $input = [
            'curp' => $request->input("curp"),
            'email' => $request->input("email"),
            'password' => $request->input("password"),
            'password_confirmation' => $request->input("confirmar_password"),
            'nombre' => $request->input("nombre"),
            'apellido_paterno' => $request->input('apellido_paterno')
        ];

        $validacion = Validator::make($input, $reglas);

        if ($validacion->fails()) {
            foreach ($validacion->errors()->all() as $error) {
                array_push($errors, $error);
            }
        } else {

            //User
            $correo = $request->input("email");
            $password = $request->input("password");

            $usuario = User::create([
                'email' => $correo,
                'password' => $password,
                'id_google' => null,
                'id_facebook' => null
            ]);

            //Datos User
            $id = $usuario->id;
            $nombre = $request->input("nombre");
            $apellido_paterno = $request->input('apellido_paterno');
            $apellido_materno = $request->input('apellido_materno');
            $curp = $request->input('curp');
        
            $datosUsuario = DatosUsuario::create([
                'id_usuario' => $id,
                'nombre' => $nombre,
                'apellido_paterno' => $apellido_paterno,
                'apellido_materno' => $apellido_materno,
                'id_genero' => null,
                'id_estado_nacimiento' => null,
                'codigo_postal' => null,
                'id_estado' => null,
                'id_municipio' => null,
                'telefono' => null,
                'ruta_imagen' => null,
                'curp' => $curp
            ]);
        
            //Datos funcionario.
            $telefono = $request->input("telefono");
            $id_rol = $request->rol;
            $id_puesto = $request->puesto;

            $funcionario = Funcionario::create([
                'id_usuario' => $id,
                'id_rol' => $id_rol,
                'id_puesto' => $id_puesto,
                'telefono' => $telefono,
                'estatus' => 1
            ]); 

        }

        if (count($errors) > 0) {
            return back()->withErrors($errors);
        } else {
            return redirect('/usuarios');
        }
    }
    
}
