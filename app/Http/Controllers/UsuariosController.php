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
use App\Permiso;
use App\Puesto;
use App\Rol;
use Illuminate\Http\Request;
use PhpParser\Node\Scalar\MagicConst\Dir;
use DB;

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
}
