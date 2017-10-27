<?php

namespace App\Http\Controllers\Auth;

use App\Area;
use App\Chat;
use App\Dependencia;
use App\Direccion;
use App\Funcionario;
use App\Http\Controllers\Controller;
use App\Permiso;
use App\Puesto;
use App\Rol;
use App\RolPermiso;
use function foo\func;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{

    use AuthenticatesUsers;
/*
    public function __construct() {
        $this->middleware('auth.web');
    }*/

    public function login(Request $request)
    {
        $correo = $request->input("email");
        $password = $request->input("password");

        if (Auth::attempt(['email' => $correo, 'password' => $password])) {
            $usuario = User::where('email', $correo )->get()->first();
            if($usuario->admin == "1") {
                $funcionario = Funcionario::where('id_usuario', '=', $usuario->id)->first();

                session(['funcionario' => $funcionario]);
                return redirect()->intended('/inicio');
            } else {
                return view('index', ["errors" => ["Usuario sin permisos de administrador"]]);
            }
        } else {
            return view('index', ["errors" => ["Usuario o contraseña incorrecto"]]);
        }
    }

    public function getlogout(){
        Auth::logout();
        session()->flush();
        return redirect('/');
    }

}
