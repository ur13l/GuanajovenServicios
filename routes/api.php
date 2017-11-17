<?php

use Illuminate\Http\Request;
use \App\Notifications\ConvocatoriaNotification;
use \App\Convocatoria;
use \App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

Route::get('/publicidad', 'PublicidadApiController@obtenerPublicidad');
Route::get('/promociones', 'PromocionesApiController@obtenerEmpresasPromociones');
Route::get('/regiones', 'RegionApiController@obtenerRegiones');
Route::get('/notificacionres', 'NotificacionesApiController@obtenerNotificaciones');
Route::get('/eventos/usuariosregistrados', 'EventoApiController@usuariosRegistrados');
Route::get('/eventos/usuariosinteresados', 'EventoApiController@usuariosInteresados');

//Autenticación API
Route::group(['prefix' => 'usuarios'], function () {
    Route::post('login', 'Auth\LoginApiController@login');
    Route::post('registrar', 'UserApiController@registrar');
    Route::post('actualizar', 'UserApiController@actualizar');
    Route::post('verificarcorreo', 'UserApiController@verificarEmail');
    Route::post('logingoogle', 'Auth\LoginApiController@loginGoogle');
    Route::post('loginfacebook', 'Auth\LoginApiController@loginFacebook');
    Route::post('login_admin', 'Auth\LoginApiController@loginAdmin');
    Route::post('curp', 'UserApiController@obtenerCurp');
    Route::post('posicion','UserApiController@obtenerPosicion');
    Route::post('actualizar-token-guanajoven', 'UserApiController@actualizarTokenGuanajoven');
});

Route::group(['prefix' => 'convocatorias'], function() {
    Route::get('/', 'ConvocatoriaApiController@obtenerConvocatorias');
    Route::post('/notificacion', 'ConvocatoriaApiController@enviarNotificacion');
});

Route::group(['prefix' => 'profile'], function () {
    Route::post('update', 'ProfileApiController@updateProfile');
    Route::post('get', 'ProfileApiController@getProfile');
});


Route::group(['prefix' => '/notificaciones'], function() {
    Route::post('/enviartoken', 'NotificacionesApiController@registrar');
    Route::post('/cancelartoken', 'NotificacionesApiController@cancelar');
    Route::post('/notificacionurl', 'NotificacionesApiController@notificacionurl');
});


Route::group(['prefix' => '/chat'], function() {
    Route::post('/enviar', 'ChatApiController@enviar');
    Route::post('/mensajes', 'ChatApiController@mensajes');
    Route::post('/mensajesAdmin', 'ChatApiController@mensajesAdmin');
    Route::post('/enviarAdmin', 'ChatApiController@enviarAdmin');
    Route::post('/buscarUsuarios','ChatApiController@buscarUsuarios');
    Route::post('/nuevoChat','ChatApiController@nuevoChat');
    Route::post('/getChat','ChatApiController@getChat');
    Route::post('/recargaListaChats','ChatApiController@recargaListaChats');
});

Route::group(['prefix' => '/eventos'], function() {
    Route::get('/','EventoApiController@obtenerEventos');
    Route::post('/marcar','EventoApiController@marcarEvento');
    Route::post('/registrar', 'EventoApiController@registrar');
    Route::post('/notificacion', 'EventoApiController@enviarNotificacion');
});

Route::group(['prefix' => '/documentos'], function () {

    Route::group(['prefix' => '/pdf'], function() {
      Route::get('idguanajoven', 'PdfController@generarPDF');
   });

   Route::group(['prefix' => '/excel'], function () {
       Route::get('reporteevento', 'ExcelController@obtenerUsuarios');
   });
});

Route::post('/promociones/registrar', 'PromocionesApiController@registrar');
