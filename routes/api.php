<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AmonestacionTiendaController;
use App\Http\Controllers\CategoriasProductosController;
use App\Http\Controllers\CategoriasUsuarioController;
use App\Http\Controllers\CategoriaTiendaController;
use App\Http\Controllers\CodigoPaisController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\EstadoVentaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PromocionProductoController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\ResenaProductoController;
use App\Http\Controllers\ResenaTiendaController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\TipoAdvertenciaController;
use App\Http\Controllers\TipoPagoController;
use App\Http\Controllers\TipoPesoController;
use App\Http\Controllers\TipoUsuarioController;
use App\Http\Controllers\ToppingsController;
use App\Http\Controllers\ToppingsProductosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\LoginController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Espacio de desarrollo

//Registro y Login
Route::post('/login', [LoginController::class, 'login']);
Route::post('/registro', [UserController::class, 'register']);

//Tipo Usuariog
Route::resource('tipo-usuario', TipoUsuarioController::class);

//Codigo Pais
Route::resource('codigo-pais', CodigoPaisController::class);

//Usuario
Route::resource('usuario', UserController::class);

//Categoria Tiendas
Route::resource('categoria-tienda', CategoriaTiendaController::class);

//Tiendas
Route::resource('tienda', TiendaController::class);
Route::post('/registroEmprendedor', [TiendaController::class,'storeEmprendedor']);

//Categoria Productos
Route::resource('categoria-producto', CategoriasProductosController::class);

//Tipo Pesos
Route::resource('tipo-peso', TipoPesoController::class);

//Marcas
Route::resource('Marca', MarcaController::class);
Route::post('edit-img-marca/{id}', [MarcaController::class, 'editImagen']);

//Productos
Route::resource('producto', ProductoController::class);

//Categorias Usuarios
Route::resource('categoria-usuario', CategoriasUsuarioController::class);

//Promocion Productos
Route::resource('promo-productos', PromocionProductoController::class);

//Toppings
Route::resource('toppings', ToppingsController::class);

//Toppings Productos
Route::resource('toppings-productos', ToppingsProductosController::class);

//Tipo Pagos
Route::resource('tipo-pago', TipoPagoController::class);

//Estado Ventas
Route::resource('estado-venta', EstadoVentaController::class);

//Ventas
Route::resource('venta', VentaController::class);

//Detalle Ventas
Route::resource('detalle-venta', DetalleVentaController::class);

//Reclamos
Route::resource('reclamo', ReclamoController::class);

//Reseña Tienda
Route::resource('rese-tienda', ResenaTiendaController::class);

//Reseña Productos
Route::resource('rese-producto', ResenaProductoController::class);

//Tipo Advertencias
Route::resource('tipo-adv', TipoAdvertenciaController::class);

// Amonestacion tiendas
Route::resource('amon-tiendas', AmonestacionTiendaController::class);


Route::middleware('auth:sanctum')->group( function () {

    //Rutas con TOKEN

});
