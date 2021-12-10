<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PDFController;
use App\Http\Models\Categoria;
use App\Http\Models\Articulo;
use App\Http\Models\Persona;
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

Route::resource('almacen/categoria','App\Http\Controllers\CategoriaController');
// Route::post('almacen/categoria','App\Http\Controllers\CategoriaController');
Route::resource('almacen/articulo','App\Http\Controllers\ArticuloController');
Route::resource('ventas/cliente','App\Http\Controllers\ClienteController');
Route::resource('compras/proveedor','App\Http\Controllers\ProveedorController');
Route::resource('compras/ingreso','App\Http\Controllers\IngresoController');
Route::resource('ventas/venta','App\Http\Controllers\VentaController');
Route::resource('seguridad/usuario','App\Http\Controllers\UsuarioController');

Auth::routes();
// Error logout 
// Route::get('/logout', 'App\Http\Auth\LoginController')->name('logout' );
Route::auth();
// Route::get('/home', 'App\Http\Controllers\HomeController@index');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta que no este definida envia al homeController 
Route::get('/{slug?}','App\Http\Controllers\HomeController@index');
// // Route::get('/imprimir', [App\Http\Controllers\HomeController::class, 'imprimir'])->name('imprimir');
// Route::get('/', 'App\Http\Controllers\VentaController@imprimir')->name('imprimir');
// Route::get('/imprimir', [App\Http\Controllers\PDFController::class, 'imprimir'])->name('imprimir');
Route::get('/', 'App\Http\Controllers\PDFController@imprimir');

// Route::get('/',function(){
//     // inicializa dompdf 
//     $pdf = App::make('dompdf.wrapper');
//     $pdf->loadHTML('<h1>Test</h1>');

// //     // Tambien se puede
// //     // $pdf=PDF::loadHTML('<h1 style="color:red">Test</h1>');

// //     // Carga una vista 
// //     $pdf=PDF::loadView('ventas/venta/index');
// //     // Returna lo guardado en pdf en el navegador
//     return $pdf->stream();
// //     // El pdf se descarga al llamar la pagina.
// //     // return $pdf->download();
// });