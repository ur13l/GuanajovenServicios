<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::auth();
Route::get('/', function () {
    return view('index');
});

//Usuarios
Route::post('/usuarios/login', 'Auth\LoginController@login');

Route::get('/usuarios/logout', 'Auth\LoginController@getlogout');

Route::get('/usuarios/nuevo', 'UsuariosController@nuevo');

Route::get('/usuarios/buscar', 'UsuariosController@buscar');

Route::post('/usuarios/registrar', 'UsuariosController@registrar');

Route::post('/usuarios/curp', 'UserApiController@obtenerCurp');

Route::post('/usuarios/obtenerPermisos', 'UsuariosController@obtenerPermisos');

Route::post('/usuarios/obtenerValoresPuesto', 'UsuariosController@obtenerValoresPuesto');


//Publicidad
Route::group(['prefix' => 'publicidad'], function () {
    Route::get('/', 'PublicidadController@index')->name('publicidad');
    Route::post('/eliminar', 'PublicidadController@eliminar');
    Route::post('/crear', 'PublicidadController@crear');
    Route::post('/actualizar', 'PublicidadController@actualizar');
    Route::get('/detalle/{id}', 'PublicidadController@detalle');
});


//Convocatorias
Route::group(['prefix' => 'convocatorias', 'middleware' => ['auth.web']], function() {
    Route::get('/', 'ConvocatoriasController@index')->name('convocatorias');
    Route::get('/nueva', 'ConvocatoriasController@nueva');
    Route::post('/eliminar', 'ConvocatoriasController@eliminar');
    Route::post('/crear', 'ConvocatoriasController@crear');
    Route::get('/editar/{id_convocatoria}', 'ConvocatoriasController@vistaEditar');
    Route::post('/editar', 'ConvocatoriasController@editar');
});

Route::group(['prefix' => 'convocatorias'], function() {
    Route::any('/registrada', 'ConvocatoriasController@registrada')->name('convocatoria.registrada');
});


//Empresas
Route::group(['prefix' => 'empresas'], function() {
    Route::get('/', 'EmpresaController@index')->name('empresas');
    Route::get('/nueva', 'EmpresaController@nueva');
    Route::post('/eliminar', 'EmpresaController@eliminar');
    Route::post('/crear', 'EmpresaController@crear');
    Route::get('/editar/{id_empresa}', 'EmpresaController@vistaEditar');
    Route::post('/editar', 'EmpresaController@editar');
});

//Promoción
Route::group(['prefix' => 'promociones'], function() {
    Route::post('/nueva', 'PromocionesController@crear');
    Route::post('/editar', 'PromocionesController@editar');
    Route::get('/eliminarPromocion/{id_promocion}/{id_empresa}', 'PromocionesController@eliminar');
});

//Chat
Route::group(['prefix' => 'chat'], function() {
      Route::get('/', 'ChatController@index')->name('chat');
});

//Jóvenes
Route::group(['prefix' => 'jovenes'], function(){
  Route::get('/', 'JovenesController@index');
  Route::get('/nuevo', 'JovenesController@nuevo');
  Route::post('/registrar', 'JovenesController@registrar');
  Route::post('/borrar', 'JovenesController@borrar');
  Route::get('/buscar', 'JovenesController@buscar');
  Route::get('/perfil/{id_usuario}', 'JovenesController@perfil');
  Route::post('/perfil', 'JovenesController@actualizar');
});

//Ordenes de servicio
Route::group(['prefix' => 'servicios'], function(){
    Route::get('/', 'ServiciosController@index');
    Route::get('/nuevo', 'ServiciosController@nuevo');
    Route::post('/registrar', 'ServiciosController@registrar');
    Route::get('/actualizar', 'ServiciosController@editar');
    Route::get('/buscar', 'ServiciosController@buscar');
    Route::get('/borrar', 'ServiciosController@borrar');
    Route::get('/editar/{id_orden_atencion}', 'ServiciosController@editar');
    Route::get('/usuariosautocomplete', 'ServiciosController@usuariosAutocomplete');
    Route::get('/jovenesautocomplete', 'ServiciosController@jovenesAutocomplete');
});

//Notificaciones
Route::group(['prefix' => 'notificaciones'], function() {
    Route::get('/', 'NotificacionesController@index')->name('notificaciones');
    Route::post('/enviar', 'NotificacionesController@enviar');
    Route::post('/eliminar', 'NotificacionesController@eliminar');
    Route::get('/lista', 'NotificacionesController@lista');
});


//Historial de notificaciones
Route::get('/historial', 'HistorialController@index');
//Reportes
Route::get('/reportes', 'ReportesController@index');
//Usuarios
Route::get('/usuarios', 'UsuariosController@index');
Route::post('/usuarios/passwordactualizada', function() {
        return view('usuarios.password_actualizado');
});

//Eventos
Route::group(['prefix' => 'eventos', 'middleware' => ['auth.web']], function () {
    Route::get('/inicio', 'EventosController@index')->name('eventos');
    Route::get('/nuevo', 'EventosController@nuevo');
    Route::post('/editar/{idEvento}', 'EventosController@editar');
    Route::post('/eliminar', 'EventosController@eliminar');
    Route::post('/guardar', 'EventosController@guardar');
    Route::post('/estadisticas/{idEvento}', 'EventosController@estadistica'); 
});

Route::group(['prefix' => 'eventos'], function() {
    Route::any('/registrado', 'EventosController@registrado')->name('evento.registrado');
});
//Video
Route::get('/video', 'VideoController@index');

//Inicio
Route::get('/inicio', 'InicioController@index');

Auth::routes();
