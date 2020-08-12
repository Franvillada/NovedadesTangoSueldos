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

Route::middleware('auth','permission')->group(function(){

    Route::post('/logout','UsersController@logout')->name('logout');
    
    Route::middleware('superadmin')->group(function(){
        Route::get('/elegir_cliente' , 'AppController@elegirClienteForm')->name('elegir_cliente');
        Route::post('/elegir_cliente', 'AppController@elegirCliente')->name('elegir_cliente');

        Route::get('/backend/clientes', 'BackendController@indexClientes')->name('backend_clientes');
        Route::get('/backend/nuevo_cliente','BackendController@showNuevoClienteForm')->name('nuevo_cliente');
        Route::post('/backend/nuevo_cliente','BackendController@nuevoCliente')->name('nuevo_cliente');
        Route::get('/backend/editar_cliente', 'BackendController@showEditarClienteForm')->name('editar_cliente');
        Route::post('/backend/editar_cliente', 'BackendController@editarCliente')->name('editar_cliente');
        Route::post('/backend/cambiar_estado_cliente','BackendController@cambiarEstadoCliente')->name('cambiar_estado_cliente');

        Route::get('/backend/novedades', 'BackendController@indexNovedades')->name('backend_novedades');
        Route::get('/backend/nueva_novedad', 'BackendController@showNuevaNovedadForm')->name('nueva_novedad');
        Route::post('/backend/nueva_novedad','BackendController@nuevaNovedad')->name('nueva_novedad');
        Route::get('/backend/editar_novedad', 'BackendController@showEditarNovedadForm')->name('editar_novedad');
        Route::post('/backend/editar_novedad', 'BackendController@editarNovedad')->name('editar_novedad');
        Route::post('/backend/cambiar_estado_novedad','BackendController@cambiarEstadoNovedad')->name('cambiar_estado_novedad');
        Route::post('/backend/importar_novedades','BackendController@importarNovedad')->name('importar_novedades');
        
        Route::get('/backend/usuarios', 'BackendController@indexUsuarios')->name('backend_usuarios');
        Route::get('/backend/nuevo_superadmin','BackendController@showNuevoSuperadminForm')->name('nuevo_superadmin');
        Route::post('/backend/nuevo_superadmin','BackendController@superadmin')->name('nuevo_superadmin');
        Route::get('/backend/editar_superadmin','BackendController@showEditarSuperadminForm')->name('editar_superadmin');
        Route::post('/backend/editar_superadmin','BackendController@editarSuperadmin')->name('editar_superadmin');
        Route::get('backend/restablecer', 'BackendController@showReestablecerForm')->name('reestablecer_superadmin');
        Route::post('backend/restablecer','BackendController@reestablecerPassword')->name('reestablecer_superadmin');
    });
    

    Route::get('/maestros/usuarios','UsersController@indexUsuarios')->name('usuarios');
    Route::get('/maestros/nuevo_usuario','UsersController@showNuevoUsuarioForm')->name('nuevo_usuario');
    Route::post('/maestros/nuevo_usuario','UsersController@registrarUsuario')->name('nuevo_usuario');
    Route::get('maestros/editar_usuario', 'UsersController@showEditarUsuarioForm')->name('editar_usuario');
    Route::get('editarInformacionPropia', 'UsersController@showEditarUsuarioForm')->name('editar_propio');
    Route::post('maestros/editar_usuario', 'UsersController@editarUsuario')->name('editar_usuario');
    Route::post('maestros/cambiar_estado_usuario', 'UsersController@cambiarEstadoUsuario')->name('cambiar_estado_usuario');
    Route::get('maestros/restablecer', 'UsersController@showReestablecerForm')->name('restablecer');
    Route::post('maestros/restablecer','UsersController@reestablecerPassword')->name('restablecer');
    
    Route::get('maestros/legajos','EmployeesController@indexLegajos')->name('legajos');
    Route::get('maestros/nuevo_legajo','EmployeesController@showNuevoLegajoForm')->name('nuevo_legajo');
    Route::post('maestros/nuevo_legajo','EmployeesController@nuevoLegajo')->name('nuevo_legajo');
    Route::get('maestros/editar_legajo', 'EmployeesController@showEditarLegajoForm')->name('editar_legajo');
    Route::post('maestros/editar_legajo', 'EmployeesController@editarLegajo')->name('editar_legajo');
    Route::post('maestros/cambiar_estado_legajo', 'EmployeesController@cambiarEstadoLegajo')->name('cambiar_estado_legajo');
    Route::post('maestros/importar_legajos','EmployeesController@importarLegajos')->name('importar_legajos');
    
    Route::get('/maestros/novedades','NoveltysController@indexNovedades')->name('novedades');
    Route::get('/maestros/nueva_relacion','NoveltysController@showNuevaRelacionForm')->name('nueva_relacion');
    Route::post('/maestros/nueva_relacion','NoveltysController@nuevaRelacion')->name('nueva_relacion');
    Route::post('maestros/eliminar_relacion','NoveltysController@eliminarRelacion')->name('eliminar_relacion');

    Route::get('registro-novedades','NoveltyRegistersController@index')->name('registro_novedades');
    Route::get('registro-novedades/nuevo','NoveltyRegistersController@showNuevoRegistroForm')->name('nuevo_registro');
    Route::post('registro-novedades/nuevo','NoveltyRegistersController@nuevoRegistro')->name('nuevo_registro');
    Route::get('registro-novedades/editar','NoveltyRegistersController@showEditarRegistroForm')->name('editar_registro');
    Route::post('registro-novedades/editar','NoveltyRegistersController@editarRegistro')->name('editar_registro');
    Route::post('registro-novedades/desinformar','NoveltyRegistersController@cambiarEstadoRegistro')->name('cambiar_estado_registro');
    Route::post('registro-novedades/eliminar','NoveltyRegistersController@eliminarRegistro')->name('eliminar_registro');
    Route::get('registro-novedades/exportar','NoveltyRegistersController@showExportarForm')->name('exportar_registros');
    Route::post('registro-novedades/exportar','NoveltyRegistersController@storeExcel')->name('exportar_registros');
    Route::get('registro-novedades/download','NoveltyRegistersController@downloadExcel');

    Route::get('/kpi','AppController@showKpi')->name('kpi')->middleware('auth');
    
});
