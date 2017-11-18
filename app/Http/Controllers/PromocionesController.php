<?php
/*
  Autor: Leonardo Lira Becerra.
  Descripción: Controlador para vista de Convocatorias.
  Fecha: 31/01/2017.
*/

namespace App\Http\Controllers;


use App\Promocion;
use App\Empresa;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PromocionesController  extends Controller{
    use ValidatesRequests;

    /**
     * Requerir logueo para las rutas que impliquen el módulo de usuarios
     * UsuariosController constructor.
     */
    public function __construct() {
        $this->middleware('auth.web');
    }

    /**
     * Crear promoción [POST]
     * Funcionalidad para crear una promoción en la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function crear(Request $request) {
      $this->validate($request, [
          'titulo' => 'required',
          'descripcion' => 'required',
          'bases' => 'required',
          'fecha_inicio' => 'required',
          'fecha_fin' => 'required',
          'codigo_promocion' => 'required',
          'url_promocion' => 'required'
      ]);


      $titulo = $request->input('titulo');
      $descripcion = $request->input('descripcion');
      $bases = $request->input('bases');
      $fecha_inicio = $request->input('fecha_inicio');
      $fecha_fin = $request->input('fecha_fin');
      $codigo_promocion = $request->input('codigo_promocion');
      $url_promocion = $request->input('url_promocion');
      $id_empresa = $request->input('id_empresa');
      //Creación de la Promoción.
      $promocion = Promocion::create(array(
          'id_empresa' => $id_empresa,
          'titulo' => $titulo,
          'descripcion' => $descripcion,
          'bases' => $bases,
          'fecha_inicio' => $fecha_inicio,
          'fecha_fin' => $fecha_fin,
          'codigo_promocion' => $codigo_promocion,
          'url_promocion' => $url_promocion
      ));

    //  DB::table('empresa_promocion')->insert(['id_empresa' => $id_empresa, 'id_promocion' => $promocion->id_promocion, 'created_at' =>  Carbon::now(),'updated_at' =>  Carbon::now()]);

      return redirect('/empresas/editar/'.$id_empresa);
    }



    /**
     * Eliminar promoción [POST]
     * Funcionalidad para eliminar una promoción en la interfaz web.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function eliminar(Request $request, $id_promocion, $id_empresa) {
        $promocion = Promocion::where('id_promocion',$id_promocion)->first();
        $promocion->delete();
        return redirect('/empresas/editar/'.$id_empresa);
    }

    /**
     * Editar promoción [POST]
     * Este método edita  una promoción seleccionada de acuerdo a su id.
     * @param $id_promoción
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editar(Request $request) {
      //Se actualiza la promoción seleccionada
      $id = $request->input('editid_promocion');
      $id_empresa = $request->input('editid_empresa');
      $promocion = Promocion::find($id);
      $empresa = Empresa::find($id_empresa);
      $empresa->updated_at =  Carbon::now();
      $empresa->save();
      $promocion->titulo = $request->input('edittitulo');
      $promocion->descripcion = $request->input('editdescripcion');
      $promocion->bases = $request->input('editbases');
      $promocion->fecha_inicio = $request->input('editfecha_inicio');
      $promocion->fecha_fin = $request->input('editfecha_fin');
      $promocion->codigo_promocion = $request->input('editcodigo_promocion');
      $promocion->url_promocion = $request->input('editurl_promocion');
      $promocion->save();

      return redirect('/empresas/editar/'.$id_empresa);
    }





}
