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

Route::get('/', function () {
    return view('auth.login');
})->middleware('checkAuth');; 
// Route::get('/reportes',function(){
// return view('reportes');
// });
Route::get('/ejecucion',function(){
return view('ejecucion');
});
Route::get('/avance',function(){
return view('avance');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//rutas administrador
Route::post('/addUser', 'personaController@store');

Route::post('/addEncargado', 'OficinasController@storeEncargado');
Route::post('/addOficina', 'OficinasController@store');
Route::get('/getOficinas', 'OficinasController@index');
Route::get('/getEncargados', 'OficinasController@show');
Route::get('/getEncargados/{id}', 'OficinasController@showEncargado');
Route::get('/getEncargado/{id}', 'OficinasController@create');
Route::get('/updateEncargado/{id}/{des}', 'OficinasController@update');
Route::get('/eliminarEncargado/{id}', 'OficinasController@destroy');
Route::post('/addObjetivo', 'ObjetivosController@store');
Route::get('/getObjetivos', 'ObjetivosController@show');
Route::get('/deleteObjetivo/{id}', 'ObjetivosController@destroy');
Route::get('/getObjetivos/{id}', 'ObjetivosController@index');
Route::get('/getObjetivo/{id}', 'ObjetivosController@showObjetivo');
Route::get('/updateObjetivo/{id}/{des}', 'ObjetivosController@update');
Route::post('/addProceso', 'ProcestrategicosController@store');
Route::get('/getProcesos', 'ProcestrategicosController@index');
Route::get('/getProcesos/{id}', 'ProcestrategicosController@show');
Route::get('/getProceso/{id}', 'ProcestrategicosController@showProceso');
Route::get('/editProceso/{id}/{des}', 'ProcestrategicosController@update');
Route::get('/deleteProceso/{id}', 'ProcestrategicosController@destroy');
Route::post('/addActividad', 'ActividadController@store');
Route::get('/getActividades', 'ActividadController@index');
Route::get('/getActividades/{id}', 'ActividadController@show');
Route::get('/getActividad/{id}', 'ActividadController@showActividad');
Route::get('/updateActividad/{id}/{des}', 'ActividadController@update');
Route::get('/deleteActividad/{id}', 'ActividadController@destroy');
Route::post('/addSubActividad', 'SubactividadesController@store');
Route::get('/getSubActividades', 'SubactividadesController@index');
Route::get('/getEjecucion', 'SubactividadesController@ejecucion');
Route::get('/getSubActividad/{id}', 'SubactividadesController@show');
Route::get('/SubActividad/{id}', 'SubactividadesController@showSubActividad');
Route::get('/updateSubActividad/{id}/{des}', 'SubactividadesController@update');
Route::post('/addEntregable', 'EntregableController@store');
Route::get('/getEntregable','EntregableController@index');
Route::get('/getAvances/{o}/{t}','EntregableController@show');
Route::get('/avances/{o}/{t}','EntregableController@avances');
Route::get('/editarAvance/{id}/{cant}','EntregableController@update');
Route::get('/avanceTrimestral/{t}','OficinasController@avanceTrimestral');
Route::get('/getMetas','EntregableController@metas');
Route::get('/getTipo','userController@index');
Route::post('/updatePass', 'userController@update');
//fin rutas administrador

// Rutas alternas

Route::get('{path}', 'HomeController@index');

//rutas para admin/predio