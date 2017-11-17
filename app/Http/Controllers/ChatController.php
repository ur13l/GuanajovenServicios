<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/
namespace App\Http\Controllers;
use App\Chat;
use App\Utils\FileUtils;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ChatController  extends Controller{
    use ValidatesRequests;

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
       $this->middleware('auth.web');
    }

    /**
     * Index [GET]
     * Carga el index de empresa con el listado de estas para revisar detalles, crear y eliminar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {

        $chats = Chat::all();
        $arr = array();
        
        foreach ($chats as $key => $chat) {
            if( $chat->ultimoMensaje() )
                $order = $chat->ultimoMensaje()->id_mensaje;
            else
                $order = 0;

            array_push($arr, array('order' => $order, 'chat' => $chat ) );
        }

        rsort($arr);

        return view('chat.index', ['chats' => $arr] );
    }
}
