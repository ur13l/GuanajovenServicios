<?php

namespace App\Http\Controllers;

use App\NotificacionConvocatoria;
use App\Http\Requests;
use App\NotificacionEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;


class EnviarCorreosApiController extends Controller
{
    protected $id_usuario;
    protected $id_convocatoria;
    protected $curp_usuario;
    protected $nombre_convocatoria;

    protected $idEvento;
    protected $nombreEvento;

    


   
}
