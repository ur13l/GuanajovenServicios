<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Region;
use App\Area;
use App\EstatusOrden;
use App\OrdenAtencion;
use Carbon\Carbon;
use App\CentroPoderJoven;
use App\DatosUsuario;
use App\Servicio;
use Auth;
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
          * Método que devuelve la vista para generar una nueva orden de atención
          *
          * @return view
          */
         public function nuevo(){
            $regiones = Region::all();
            $centros = CentroPoderJoven::all();
            $areas = Area::all();
            $servicios = Servicio::all();
            $estatus_orden = EstatusOrden::all();
           return view('servicios.nuevo', ['regiones' => $regiones, 
            'centros' => $centros, 'areas' => $areas, 'servicios' => $servicios,
            'estatus_orden' => $estatus_orden]);
        }
    
        /**
         * Se devuelve la vista de edición.
         *
         * @return void
         */
        public function editar($id_orden_atencion, Request $request){
           $regiones = Region::all(); 
           $centros = CentroPoderJoven::all();
           $areas = Area::all();
           $servicios = Servicio::all();
           $ordenes_atencion = OrdenAtencion::find($id_orden_atencion);    
           $estatus_orden = EstatusOrden::all();
           $datosUsuario = DatosUsuario::all();
            return view('servicios.editar', ['ordenes_atencion' => $ordenes_atencion, 'regiones' => $regiones,
            'centros' => $centros, 'areas' => $areas, 'servicios' => $servicios, 'estatus_orden' => $estatus_orden,
            'datosUsuario' => $datosUsuario]);
        }

        public function actualizar(Request $request){
            $ordenes_atencion = OrdenAtencion::find($request->input("id_orden_atencion"));
            $ordenes_atencion->update($request->all());
                      
            /*-------------------------------- Documentos --------------------------------*/
            //Se revisan los documentos que hay que eliminar
           /* $idsEliminar = json_decode($request->input('input-deleted-docs'));
            for($i = 0, $max = count($idsEliminar); $i < $max; $i++) {
                $documento = Documento::find($idsEliminar[$i]);
                $documento->delete();
            }

            //Se revisan los documentos que hay que actualizar
            if($request->input('doc-id')) {
                foreach($request->input('doc-id') as $index => $id_documento) {
                    //Se revisa si existe el documento
                    $documento = Documento::find($id_documento);
                    $titulo = $request->input('doc-titulo')[$index];
                    $file = $request->file('doc-file-' . $id_documento);
                        
                    $documento->titulo = $titulo;
                    if(isset($file)) {
                        FileUtils::eliminar($documento->ruta_documento);
                        $documento->ruta_documento = FileUtils::guardar($file, 'storage/docs/', 'doc_');//Actualizando el formato
                        $formato = Formato::where('nombre',$file->getClientOriginalExtension())->get()->first();
                        $documento->id_formato = isset($formato->id_formato) ? $formato->id_formato : Formato::OTRO; //El 5 representa otro formato
                    }
                    $documento->save();
                }
            }
            
            //Se cargan los nuevos documentos
            $titulos = $request->input('doc-titulo-nuevo');
            $files = $request->file('doc-file-nuevo');
            if(isset($files)) {
                foreach ($files as $index => $file) {
                $rutaDoc = FileUtils::guardar($file, 'storage/docs/', 'doc_');
                //Actualizando el formato
                $formato = Formato::where('nombre', $file->getClientOriginalExtension())->get()->first();
                $idFormato = isset($formato->id_formato) ? $formato->id_formato : Formato::OTRO; //El 5 representa otro formato
                Documento::create(array(
                        'titulo' => $titulos[$index],
                        'ruta_documento' => $rutaDoc,
                        'id_formato' => $idFormato,
                        'id_convocatoria' => $convocatoria->id_convocatoria
                    )
                );
            }
        }*/
        $ordenes_atencion->save();
        return redirect('/servicios/editar/');

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
         * Búsqueda de ordenes de servicio
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

       

     
        /**
         * Método que devuelve un arreglo de usuarios con datos en funcionario.
         *
         * @param Request $request
         * @return JSON
         */
        public function usuariosAutocomplete(Request $request) {
            $query = $request->input('q');
            $array = [];
            
            $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
                ->where('datos_usuario.nombre', 'like', '%'.$query.'%')
                ->orWhere('datos_usuario.apellido_paterno', 'like', '%'.$query.'%')
                ->orWhere('datos_usuario.apellido_materno', 'like', '%'.$query.'%')
                ->get();
            foreach($usuarios as $usuario) {
                if($usuario->funcionario){
                    $array[] = ['text' => $usuario->datosUsuario->nombre ." ". $usuario->datosUsuario->apellido_paterno ." ". $usuario->datosUsuario->apellido_materno, 
                        'id' => $usuario->id, 
                        'highlight' => $usuario->datosUsuario->nombre ." ". $usuario->datosUsuario->apellido_paterno ." ". $usuario->datosUsuario->apellido_materno];
                }
            }
            return json_encode($array);
        }

        /**
         * Devuelve la lista de jóvenes.
         *
         * @param Request $request
         * @return JSON
         */
        public function jovenesAutocomplete(Request $request) {
            $query = $request->input('q');
            $array = [];
            
            $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
                ->where('datos_usuario.fecha_nacimiento', '>', Carbon::now('America/Mexico_City')->subYears(30))
                ->where(function ($q) use ($query){
                    $q ->where('datos_usuario.nombre', 'like', '%'.$query.'%')
                    ->orWhere('datos_usuario.apellido_paterno', 'like', '%'.$query.'%')
                    ->orWhere('datos_usuario.apellido_materno', 'like', '%'.$query.'%');
                })
                ->get();
            foreach($usuarios as $usuario) {
                $array[] = ['text' => $usuario->datosUsuario->nombre ." ". $usuario->datosUsuario->apellido_paterno ." ". $usuario->datosUsuario->apellido_materno, 
                    'id' => $usuario->id, 
                    'highlight' => $usuario->datosUsuario->nombre ." ". $usuario->datosUsuario->apellido_paterno ." ". $usuario->datosUsuario->apellido_materno];
            }
            return json_encode($array);
        }


        public function registrar(Request $request) {
            $usuario = Auth::user();
            $orden = OrdenAtencion::create($request->all() + ['id_usuario_captura' => $usuario->id]);
            $orden->servicios()->attach($request->id_servicio);

            $usuariosRelacionados = explode(',', $request->input('id_usuarios_involucrados'));
            foreach($usuariosRelacionados as $idU) {
                $orden->involucrados()->attach($idU);
            }

            $beneficiadosRelacionados = explode(',', $request->input('id_beneficiados_relacionados'));
            foreach($beneficiadosRelacionados as $idU) {
                $orden->beneficiados()->attach($idU);
            }
            return redirect('/servicios');
        }

        

 
}
