<?php

use App\Http\Controllers\ProductoServicioController;
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
use App\Http\Controllers\ResenaServicioController;


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
Route::post('/Updatefotouser/{id}', [UserController::class, 'UpdatefotoUser']);

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
Route::get('/show/{id}', [TiendaController::class, 'show']); // trae una sola tienda
/* Route::get('/getshowTienda/{id}', [TiendaController::class, 'getshowTienda']); */
Route::post('/updatetienda/{id}', [TiendaController::class, 'updateTienda']);
/* Route::get('/getcategotiatiendas/{id}', [TiendaController::class, 'getCategotiaTiendas']);
Route::get('/getproductocategorias/{id}', [TiendaController::class, 'getProductoCategorias']); */
Route::get('/showCateProducto', [TiendaController::class,'showCateProducto']);

//Categoria Productos

Route::resource('categoria-producto', CategoriasProductosController::class);
Route::get('/get-cat-prod-by-tienda/{id}', [CategoriasProductosController::class, 'getCatProducByTienda']);
Route::get('/getCategProductTienda/{id}', [CategoriasProductosController::class, 'getCategProductTienda']);

//Tipo Pesos
Route::resource('tipo-peso', TipoPesoController::class);
/* Route::get('/getTipoPesoTienda/{id}', [TipoPesoController::class, 'getTipoPesoTienda']); */

//Marcas
Route::resource('Marca', MarcaController::class);
Route::post('edit-img-marcas/{id}', [MarcaController::class, 'editImagen']);
Route::get('get-marca-by-tienda/{id}', [MarcaController::class, 'getMarcaTienda']);

//Productos
Route::resource('producto', ProductoController::class);
Route::get('get-prod-by-tienda/{id}', [ProductoController::class, 'getProductoByTienda']);
Route::get('get-prod-by-categoria/{id}', [ProductoController::class, 'getProductosByCategoria']);
Route::post('prod-update/{id}', [ProductoController::class, 'Actualizar']);
Route::get('productos/{id}', [ProductoController::class, 'getProductoTienda']);
Route::get('showCateProducto/{id}', [ProductoController::class, 'showCateProducto']);
Route::get('/produc', [ProductoController::class, 'indexx']);


//Categorias Usuarios
Route::resource('categoria-usuario', CategoriasUsuarioController::class);

//Promocion Productos

Route::resource('promo-productos', PromocionProductoController::class);
Route::get('get-prod-by-tienda/{id}', [PromocionProductoController::class, 'getProductoByTienda']);

Route::get('get-promo-productos-by-tienda/{id}', [PromocionProductoController::class, 'getPromoProductoTienda']);


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
Route::get('get-ventas-by-usuario/{id}', [VentaController::class, 'getVentasByUsuario']);
//Detalle Ventas
Route::resource('detalle-venta', DetalleVentaController::class);
Route::get('detalle-by-venta/{id}', [DetalleVentaController::class,'showDetallesByVentas']);
Route::get('producto-mas-vendido/{id}', [DetalleVentaController::class,'productosMasVendidos']);

//Reclamos
Route::resource('reclamo', ReclamoController::class);

//Reseña Tienda
Route::resource('rese-tienda', ResenaTiendaController::class);
Route::get('get-rese-tienda-usuario/{id}', [ResenaTiendaController::class, 'getReseTiendaByUsuario']);
Route::get('get-rese-tienda-tienda/{id}', [ResenaTiendaController::class, 'getReseTiendaByTienda']);
Route::get('init-rese-tienda/{idt}/{idu}', [ResenaTiendaController::class, 'initResePage']);
//Ruta de prueba
//Route::get('actualizar-puntuacion-tienda/{id}', [ResenaTiendaController::class, 'savePuntuacionTienda']);

//Reseña Productos
Route::resource('rese-producto', ResenaProductoController::class);
Route::get('get-rese-producto-usuario/{id}', [ResenaProductoController::class, 'getReseProductoByUsuario']);
Route::get('get-rese-producto-tienda/{id}', [ResenaProductoController::class, 'getReseProductoByProducto']);
Route::get('init-rese-producto/{idp}/{idu}', [ResenaProductoController::class, 'initResePage']);
//Ruta de prueba
//Route::get('actualizar-puntuacion-producto/{id}', [ResenaProductoController::class, 'savePuntuacionProducto']);

//Reseña Servicios
Route::resource('rese-servicio', ResenaServicioController::class);
Route::get('get-rese-servicios-usuario/{id}', [ResenaServicioController::class, 'getReseServicioByUsuario']);
Route::get('get-rese-servicios-tienda/{id}', [ResenaServicioController::class, 'getReseServicioByServicio']);


//Tipo Advertencias
Route::resource('tipo-adv', TipoAdvertenciaController::class);

// Amonestacion tiendas
Route::resource('amon-tiendas', AmonestacionTiendaController::class);

// Home (usuario)
Route::post('/save-referido-user', [HomeController::class, 'saveReferidoUsuario']);
Route::get('/get-home/{id}', [HomeController::class, 'getHome']);
Route::get('/get-tienda-fav/{id}', [HomeController::class, 'getTiendaFav']);

// Producto servicio
Route::resource('producto-servicio', ProductoServicioController::class);
Route::get('/get-producto-servicio/{id}', [ProductoServicioController::class, 'getProductoServicio']);
Route::post('/edit-img-productos/{id}', [ProductoServicioController::class, 'editImagenes']);

// Producto servicio
Route::resource('rese-servicio', ResenaServicioController::class);



Route::middleware('auth:sanctum')->group( function () {

    //Rutas con TOKEN

});
