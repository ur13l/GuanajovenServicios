<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Region;
use App\Area;
use App\OrdenAtencion;
use Carbon\Carbon;
use App\CentroPoderJoven;
use App\DatosUsuario;
use Illuminate\Support\Facades\View;

class ServiciosController extends Controller{    

        /**
         * Método que devuelve la página principal de las órdenes de atención.
         *
         * @param Request $request
         * @return View
         */
        public function index(Request $request){
            $ordenes = OrdenAtencion::leftJoin('datos_usuario as datos_usuario_responsable', 'id_usuario_responsable', '=', 'datos_usuario_responsable.id_usuario')
                ->leftJoin('datos_usuario as datos_joven_responsable', 'id_joven_responsable', '=', 'datos_joven_responsable.id_usuario')
                ->leftJoin('usuario as joven_responsable', 'id_joven_responsable', '=', 'joven_responsable.id')
                ->leftJoin('area', 'id_area', '=', 'area.id')
                ->paginate(10);
     
            return view('servicios.index', ['ordenes' => $ordenes, 'tipo' => 'def', 'columna' => '']);
         }


         /**
          * Método para borrar una orden de atención.
          *
          * @param Request $request
          * @return void
          */
        public function borrar(Request $request){
            $idOrdenAtencion = $request->input('id_orden_atencion');
            $orden = OrdenAtencion::find($idOrdenAtencion);
            $orden->delete();
            return redirect()->back();    
        }     

        /**
         * Búsqueda de órdenes de servicio
         *
         * @param Request $request
         * @return void
         */
        public function buscar(Request $request){
            $q = $request->q;
            $columna = $request->columna ?: 'fecha_inicio';
            $tipo = $request->tipo ?: 'desc';
            $ordenes = OrdenAtencion::leftJoin('datos_usuario as datos_usuario_responsable', 'id_usuario_responsable', '=', 'datos_usuario_responsable.id_usuario')
            ->leftJoin('datos_usuario as datos_joven_responsable', 'id_joven_responsable', '=', 'datos_joven_responsable.id_usuario')
            ->leftJoin('usuario as joven_responsable', 'id_joven_responsable', '=', 'joven_responsable.id')
            ->leftJoin('area', 'id_area', '=', 'area.id')
            ->where(function ($query) use ($q){
              $query -> where('id_orden_atencion', 'like', "%$q%")
                     -> orWhere('fecha_inicio', 'like', "%$q%")
                     -> orWhere('area.nombre', 'like', "%$q%")
                     -> orWhere('datos_usuario_responsable.nombre', 'like', "%$q%")
                     -> orWhere('datos_usuario_responsable.apellido_paterno', 'like', "%$q%")
                     -> orWhere('datos_usuario_responsable.apellido_materno', 'like', "%$q%")
                     -> orWhere('datos_joven_responsable.nombre', 'like', "%$q%")
                     -> orWhere('datos_joven_responsable.apellido_paterno', 'like', "%$q%")
                     -> orWhere('datos_joven_responsable.apellido_materno', 'like', "%$q%")
                     -> orWhere('datos_joven_responsable.curp', 'like', "%$q%")
                     -> orWhere('joven_responsable.email', 'like', "%$q%")
                     -> orWhere('titulo', 'like', "%$q%")
                     -> orWhere('descripcion', 'like', "%$q%");
            })
            ->orderBy($columna, $tipo)
            ->paginate(10);      
            
            return View::make('servicios.lista', ['ordenes' => $ordenes, 'tipo' => $tipo, 'columna' => $columna])->render();      
          }

        public function nuevo(){
            $regiones = Region::all();
            $centros = CentroPoderJoven::all();
            $areas = Area::all();
           return view('servicios.nuevo', ['regiones' => $regiones, 'centros' => $centros, 'areas' => $areas]);
        }

        public function editar(){
            return view('servicios.editar');
        }

     
        public function usuariosAutocomplete(Request $request) {
            $array = ["suggestions" => []];
            $usuarios = User::all();
            foreach($usuarios as $usuario) {
                    $array["suggestions"][] = ['value' => $usuario->datosUsuario->nombre, 'data' => "" . $usuario->id ];
               
            }
            return json_encode($array);
        }
 
}
