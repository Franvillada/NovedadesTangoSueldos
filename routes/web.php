<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::post('/login','UsersController@login')->name('login');

Route::middleware('auth')->group(function(){
    Route::post('/logout','UsersController@logout')->name('logout');
    
    Route::get('/maestros/usuarios','UsersController@indexUsuarios')->name('usuarios');
    Route::get('/maestros/nuevo_usuario','UsersController@showNuevoUsuarioForm')->name('nuevo_usuario');
    Route::post('/maestros/nuevo_usuario','UsersController@registrarUsuario')->name('nuevo_usuario');
    Route::get('maestros/editar_usuario', 'UsersController@showEditarUsuarioForm')->name('editar_usuario');
    Route::post('maestros/editar_usuario', 'UsersController@editarUsuario')->name('editar_usuario');
    Route::post('maestros/cambiar_estado_usuario', 'UsersController@cambiarEstadoUsuario')->name('cambiar_estado_usuario');
    Route::get('maestros/reestablecer', 'UsersController@showReestablecerForm')->name('reestablecer');
    Route::post('maestros/reestablecer','UsersController@reestablecerPassword')->name('reestablecer');
    
    Route::get('/maestros/legajos','EmployeesController@indexLegajos')->name('legajos');
    Route::get('/maestros/nuevo_legajo','EmployeesController@showNuevoLegajoForm')->name('nuevo_legajo');
    Route::post('/maestros/nuevo_legajo','EmployeesController@añadirLegajo')->name('nuevo_legajo');
    Route::get('maestros/editar_legajo', 'EmployeesController@showEditarLegajoForm')->name('editar_legajo');
    Route::post('maestros/editar_legajo', 'EmployeesController@editarLegajo')->name('editar_legajo');
    Route::post('maestros/cambiar_estado_legajo', 'EmployeesController@cambiarEstadoLegajo')->name('cambiar_estado_legajo');
    
    Route::get('/maestros/novedades','NoveltysController@indexNovedades')->name('novedades');

    Route::get('/kpi','AppController@showKpi')->name('kpi')->middleware('auth');
    
});
