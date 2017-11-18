<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\OrdenAtencion;
use Carbon\Carbon;
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
            $ordenes = OrdenAtencion::paginate(10);
     
            return view('servicios.index', ['ordenes' => $ordenes, 'tipo' => 'def', 'columna' => '']);
         }

        public function nuevo(){
           return view('servicios.nuevo');
        }

        public function editar(){
            return view('servicios.editar');
        }

     
 
}
