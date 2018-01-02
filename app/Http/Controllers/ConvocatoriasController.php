<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/

namespace App\Http\Controllers;


use App\Convocatoria;
use App\User;
use App\Documento;
use App\Formato;
use App\Utils\FileUtils;
use Mail;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class ConvocatoriasController extends Controller {
    //use ValidatesRequests;

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        //$this->middleware('auth.web');
    }

    /**
     * Index [GET]
     * Carga el index de convocatorias con el listado de estas para revisar detalles, crear y eliminar
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request) {
        $convocatorias = Convocatoria::orderBy('fecha_cierre')->get();
        return view('convocatorias.index', array('convocatorias' => $convocatorias));
    }

    /**
     * Nueva Convocatoria [GET]
     * Método para mostrar la vista con el formulario para nueva convocatoria.
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function nueva(Request $request) {
        return view('convocatorias.nueva');
    }

    /**
     * Editar convocatoria [GET]
     * Este método devuelve la vista para editar una convocatoria seleccionada de acuerdo a su id.
     * @param $id_convocatoria
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function vistaEditar($id_convocatoria) {
        $convocatoria = Convocatoria::find($id_convocatoria);
        return view('convocatorias.editar', array('convocatoria' => $convocatoria));
    }


    /**
     * Eliminar convocatoria [POST]
     * Función que permite eliminar una convocatoria del sistema.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function eliminar(Request $request) {
        $id = $request->input('id-eliminar');
        $convocatoria = Convocatoria::find($id);
        $convocatoria->delete();
        return  redirect()->route('convocatorias');
    }


    /**
     * Crear convocatoria [POST]
     * Funcionalidad para crear una convocatoria en la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function crear(Request $request) {
        $this->validate($request, [
            'titulo' => 'required',
            'descripcion' => 'required',
            'fecha_inicio' => 'required',
            'fecha_cierre' => 'required',
            'imagen' => 'required',
            'documentos' => 'required'
        ]);

        $titulo = $request->input('titulo');
        $descripcion = $request->input('descripcion');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaCierre = $request->input('fecha_cierre');
        $rutaImagen = null;

        $imagen = $request->file('imagen');
        $documentos = $request->file('documentos');

        //Cargado de la imagen principal de la convocatoria.
        $rutaImagen = FileUtils::guardar($request->file('imagen'), 'storage/convocatorias/', 'conv_');

        //Creación de la convocatoria.
        $convocatoria = Convocatoria::create(array(
            'titulo' => $titulo,
            'descripcion' => $descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_cierre' => $fechaCierre,
            'estatus' => 1,
            'ruta_imagen' => $rutaImagen
        ));

        foreach ($documentos as $documento) {
            if ($documento->isValid()) {
                $rutaDoc = FileUtils::guardar($documento, 'storage/docs/', 'doc_');

                //Obtener nombre
                $titulo = $documento->getClientOriginalName();

                //Obtener el formato del documento
                $formato = Formato::where('nombre',$documento->getClientOriginalExtension())->get()->first();


                //Se guarda el documento en BD
                Documento::create(array(
                   'id_convocatoria' => $convocatoria->id_convocatoria,
                    'titulo' => $titulo,
                    'id_formato' => isset($formato) ? $formato->id_formato : Formato::OTRO,
                    'ruta_documento' => $rutaDoc
                ));
            }
        }



        return redirect('/convocatorias');
    }


    public function editar(Request $request) {
        //Se actualiza la convocatoria seleccionada
        $id = $request->input('id_convocatoria');
        $convocatoria = Convocatoria::find($id);
        $convocatoria->update($request->all());

        //Se elimina la imagen anterior (en caso de haberse cambiado)
        $file = $request->file('imagen');
        if(isset($file)) {
            FileUtils::eliminar($convocatoria->ruta_imagen);
            $convocatoria->ruta_imagen = FileUtils::guardar($file, 'storage/convocatorias/', 'conv_');
        }

        //Se revisan los documentos que hay que eliminar
        $idsEliminar = json_decode($request->input('input-deleted-docs'));
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
        }
        $convocatoria->save();
        return redirect('/convocatorias/editar/'.$convocatoria->id_convocatoria);
    }


    /**
     * Devuelve la vista que se abre a partir del correo enviado.
     * @param Request $request
     * @return Response
     */
    public function registrada(Request $request) {
        $id_usuario = $request->id_usuario;
        $id_convocatoria = $request->id_convocatoria;
        $curp_usuario = $request->curp_usuario;
        $nombre_convocatoria = $request->nombre_convocatoria;
        $convocatoria = Convocatoria::find($id_convocatoria);
        $usuario = User::find($id_usuario);

        if ($convocatoria->usuarios->contains($usuario)) {
            return view('layout.usuario_listo', ['titulo' => $nombre_convocatoria]);
        } else {
            return $this->enviarCorreoGuanajoven($usuario, $convocatoria, $curp_usuario, $nombre_convocatoria);
        }
    }

    /*************** FUNCIONES PRIVADAS ********************/

    private function enviarCorreoGuanajoven($usuario, $convocatoria,$curp_usuario, $nombre_convocatoria) {
        $convocatoria->usuarios()->attach($usuario->id);

        Mail::send('correos.notificacion_enviada',
            //variables para la vista
            ['curp_usuario' => $curp_usuario, 'titulo' => $nombre_convocatoria, 'tipo' => 'la convocatoria', 'logo' => url('/img/logo_guanajoven.png')],

            function ($message) use ($usuario, $curp_usuario, $nombre_convocatoria) {
            //Desde donde llega el mensaje
            $message->from('guanajoven@gmail.com', 'Guanajoven');
            //Mensaje para el usuario
            $message->to( $usuario->email, 'Administrador')->subject('Nuevo registro a convocatoria: '.$nombre_convocatoria);
        });

        return view('layout.usuario_registrado', ['titulo' => $nombre_convocatoria]);
    }


}
