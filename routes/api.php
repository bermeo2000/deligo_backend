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
use App\Http\Controllers\HomeController;




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

//Tipo Usuario
Route::resource('tipo-usuario', TipoUsuarioController::class);

//Codigo Pais
Route::resource('codigo-pais', CodigoPaisController::class);

//Usuario
Route::resource('usuario', UserController::class);
Route::get('/user-index', [UserController::class, 'index']);
Route::post('/usuario-update/{id}', [UserController::class, 'updateUser']);
Route::post('/updat-User-Email/{id}', [UserController::class, 'updatUserEmail']);
Route::post('/updat-User-Password/{id}', [UserController::class, 'updateditPassword']);
Route::post('/updat-User-Image/{id}', [UserController::class, 'updatUserImage']);
Route::get('/get-user/{id}', [UserController::class, 'getUser']);


//Categoria Tiendas
Route::resource('categoria-tienda', CategoriaTiendaController::class);

//Tiendas
Route::resource('tienda', TiendaController::class);
Route::post('/registroEmprendedor', [TiendaController::class,'storeEmprendedor']);
Route::post('/updatefotoTienda/{id}', [TiendaController::class,'Updatefototienda']);
Route::post('/updateRedes/{id}', [TiendaController::class,'updateRedes']);
Route::post('/updateDelivery/{id}', [TiendaController::class,'updateDelivery']);
Route::get('/get-tienda-by-cat/{id}', [TiendaController::class, 'getAllTiendasCategoria']);
Route::get('/get-tienda/{id}', [TiendaController::class, 'getTienda']);
Route::get('/show/{id}', [TiendaController::class, 'show']);
Route::post('/updatetienda/{id}', [TiendaController::class, 'updateTienda']);
//Categoria Productos
Route::resource('categoria-producto', CategoriasProductosController::class);
Route::get('/get-cat-prod-by-tienda/{id}', [CategoriasProductosController::class, 'getCatProducByTienda']);


//Tipo Pesos
Route::resource('tipo-peso', TipoPesoController::class);

//Marcas
Route::resource('Marca', MarcaController::class);
Route::post('edit-img-marca/{id}', [MarcaController::class, 'editImagen']);

//Productos
Route::resource('producto', ProductoController::class);
Route::get('get-prod-by-tienda/{id}', [ProductoController::class, 'getProductoByTienda']);
Route::get('get-prod-by-categoria/{id}', [ProductoController::class, 'getProductosByCategoria']);
Route::post('prod-update/{id}', [ProductoController::class, 'Actualizar']);


//Categorias Usuarios
Route::resource('categoria-usuario', CategoriasUsuarioController::class);

//Promocion Productos
Route::resource('promo-productos', PromocionProductoController::class);

//Toppings
Route::resource('toppings', ToppingsController::class);
Route::get('get-topping-by-tienda/{id}', [ToppingsController::class, 'getToppingsTienda']);
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
Route::get('get-rese-tienda-usuario/{id}', [ResenaTiendaController::class, 'getReseTiendaByUsuario']);
Route::get('get-rese-tienda-tienda/{id}', [ResenaTiendaController::class, 'getReseTiendaByTienda']);
//Ruta de prueba
//Route::get('actualizar-puntuacion-tienda/{id}', [ResenaTiendaController::class, 'savePuntuacionTienda']);

//Reseña Productos
Route::resource('rese-producto', ResenaProductoController::class);
Route::get('get-rese-producto-usuario/{id}', [ResenaProductoController::class, 'getReseProductoByUsuario']);
Route::get('get-rese-producto-tienda/{id}', [ResenaProductoController::class, 'getReseProductoByProducto']);
//Ruta de prueba
//Route::get('actualizar-puntuacion-producto/{id}', [ResenaProductoController::class, 'savePuntuacionProducto']);

//Tipo Advertencias
Route::resource('tipo-adv', TipoAdvertenciaController::class);

// Amonestacion tiendas
Route::resource('amon-tiendas', AmonestacionTiendaController::class);

// Home (usuario)
Route::post('/save-referido-user', [HomeController::class, 'saveReferidoUsuario']);
Route::get('/get-home/{id}', [HomeController::class, 'getHome']);


Route::middleware('auth:sanctum')->group( function () {

    //Rutas con TOKEN

});
