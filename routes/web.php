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
    return view('auth/login');
});

// ALMACEN
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');


// VENTAS
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/venta','VentaController');

//COMPRAS
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');

//SEGURIDAD
Route::resource('seguridad/usuario','UsuarioController');


Route::auth();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{slug?}','HomeController@index');
