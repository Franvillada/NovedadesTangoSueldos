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
Route::post('/logout','UsersController@logout')->name('logout');

Route::get('/register','UsersController@showRegistrationForm')->middleware('auth');
Route::post('/register','UsersController@register')->name('register');

Route::get('/kpi','AppController@showKpi')->name('kpi')->middleware('auth');

Route::get('/maestros/legajos','AppController@indexLegajos')->name('legajos');
Route::get('/maestros/nuevo_legajo','AppController@showNuevoLegajoForm')->name('nuevo_legajo');
Route::post('/maestros/nuevo_legajo','AppController@añadirLegajo')->name('nuevo_legajo');
Route::get('maestros/editar_legajo', 'AppController@showEditarLegajoForm')->name('editar_legajo');
Route::post('maestros/editar_legajo', 'AppController@editarLegajo')->name('editar_legajo');
Route::post('', 'AppController@cambiarEstadoLegajo')->name('cambiar_estado_legajo');

Route::get('/maestros/novedades','AppController@indexNovedades')->name('novedades');
Route::get('/maestros/usuarios','AppController@indexUsuarios')->name('usuarios');
Route::get('/maestros/nuevo_usuario','AppController@showNuevousuarioForm')->name('nuevo_usuario');
Route::post('/maestros/nuevo_usuario','AppController@añadirusuario')->name('nuevo_usuario');
Route::get('maestros/editar_usuario', 'AppController@showEditarusuarioForm')->name('editar_usuario');
Route::post('maestros/editar_usuario', 'AppController@editarusuario')->name('editar_usuario');
Route::post('maestros/inhabilitar_usuario', 'AppController@inhabilitarusuario')->name('inhabilitar_usuario');