<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\DatosUsuario;
use Illuminate\Support\Facades\View;

class ServiciosController extends Controller{    
        public function index(Request $request){
            $usuarios = User::leftJoin('datos_usuario', 'usuario.id', '=', 'datos_usuario.id_usuario')
            ->where('fecha_nacimiento', '>',Carbon::now('America/Mexico_City')->subYears(30) )->paginate(20);
     
            return view('servicios.index', ['usuarios' => $usuarios, 'tipo' => 'def', 'columna' => '']);
         }

         public function nuevo(){
           
            return view('servicios.nuevo');
         }
     
 
}
