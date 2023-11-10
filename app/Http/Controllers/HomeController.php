<?php

namespace App\Http\Controllers;

use App\Models\PromocionProducto;
use App\Models\CategoriaTienda;
use App\Models\Producto;
use App\Models\User;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // En este controller estan presentes las consultas para el home
    // con el fin de optimizar y hacer una sola petición

    public function getHome($id)
    {
        // Hago esto para validar la ciudad en las consultas
        $user = User::find($id);

        $categoria_tiendas = CategoriaTienda::where('estado', 1)->get();
        $tienda_fav = $this->getTiendaFav_DB($id);

        $home = array();

        /* Valida la ciudad */
        $tiendas = DB::table('tiendas')
        ->join('categoria_tiendas', 'tiendas.id_categoria_tienda', '=', 'categoria_tiendas.id')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('tiendas.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();
        $is_tiendas = $this->validateQuery($tiendas);

        /* Valida ciudad */
        $productos = DB::table('productos')
        ->join('tiendas','tiendas.id','=', 'productos.id_tienda')
        ->where('tiendas.estado', 1)
        ->select('productos.*')
        ->where('productos.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();
        $is_productos = $this->validateQuery($productos);
        
        /* Valida ciudad */
        $servicios = DB::table('producto_servicios')
        ->join('tiendas','tiendas.id','=', 'producto_servicios.id_emp_servicio')
        ->where('tiendas.estado', 1)
        ->select('producto_servicios.*')
        ->where('producto_servicios.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();
        $is_servicios = $this->validateQuery($servicios);

        /* Valida ciudad */
        $promocion_productos = DB::table('promocion_productos')
        ->join('productos', 'promocion_productos.id_producto', '=', 'productos.id')
        ->join('tiendas','tiendas.id','=', 'productos.id_tienda')
        ->select('promocion_productos.*', 'productos.nombre as nombre_promo', 'productos.imagen')
        ->where('promocion_productos.estado', 1)
        ->where('productos.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();
        $is_promocion_productos = $this->validateQuery($promocion_productos);

        $deliTOP = $this->getDeliTop($user);

        array_push(
            $home,
            [
                'categoria_tiendas' => $categoria_tiendas,
                'tiendas' => [
                    't' => $tiendas,
                    'status' => $is_tiendas,
                ],
                'productos' => [
                    'p' => $productos,
                    'status' => $is_productos,
                ],
                'servicios' => [
                    's' => $servicios,
                    'status' => $is_servicios,
                ],
                'promocion' => [
                    'promo' => $promocion_productos,
                    'status'=> $is_promocion_productos,
                ],
                'tienda_fav' => $tienda_fav,
                'deliTOP' => $deliTOP,
            ]
        );

        return response()->json($home, 200);
    }

    /* Valida si vienen vacias la consultas principales del home */
    private function validateQuery($q)
    {
        if ($q == '[]') {
            return false;
        } else {
            return true;
        }
    }

    public function saveReferidoUsuario(Request $request)
    {
        $validData = $request->validate([
            'id_user' => 'required',
            'codigo_referido_usuario' => 'required'
        ]);

        $user_ref = User::find($validData['id_user']);
        if (is_null($user_ref)) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        if ($this->validacionCodigo($validData['codigo_referido_usuario'])) {

            $this->aumentarVentas($validData['codigo_referido_usuario']);
            $user_ref->codigo_referido_usuario = $validData['codigo_referido_usuario'];
            /* 
                Suma de PuntosGO
                Actualmente se suman 100 pero esto cambiaría dependiendo de lo que se defina 16/9/23
            */
            $user_ref->puntos_go = 100;
            $user_ref->save();

            return response()->json(['message' => 'Referido de usuario guardado correctamente'], 200);
        } else {
            return response()->json(['message' => 'El codigo ingresado no existe. Vuelve a intentarlo.'], 404);
        }


    }
    private function validacionCodigo($codigo)
    {
        /* 
        Esta función valida que el codigo que el usuario ha ingresado exista
        es decir que sea el mismo de un emprendedor, para así asignarlo 
        y mostrar la tienda como fav
        */
        $user = User::where('estado', 1)
            ->where('codigo_referido', $codigo)
            ->get();
        if ($user->isEmpty()) {
            return false;
        }
        return true;
    }
    private function aumentarVentas($codigo)
    {
        $user = User::where('estado', 1)
            ->where('codigo_referido', $codigo)
            ->get();
        if ($user->isEmpty()) {
            return response()->json("El codigo de referido no existe", 404);
        }
        $user[0]->ventas = $user[0]->ventas + 3;
        $user[0]->save();
    }

    private function getTiendaFav_DB($id_user)
    {
        // Como funcionan los errores aquí
        /* 
            Para manejarlo en frontend:
            1 = Cuando por lo que sea exista un problema con el id del usuario retorna esta opción
            2 = Cuando por lo que sea no exista el emprendedor con ese código de usuario retorna esta opción
            3 = Cuando exista algún problema con la consulta de la tienda retorna esta opción
            4 = Cuando el usuario no tiene codigo de referido
        */
        // Quizá no es el mejor manejo de errores pero sirve de momento
        $user = DB::table('users')
            ->where('users.id', $id_user)
            ->get();

        if ($user[0]->codigo_referido_usuario == null) {
            $tienda_fav = 4;
            return $tienda_fav;
        }
        
        if ($user == '[]') {
            $tienda_fav = 1;
            return $tienda_fav;
        }

        $emp = DB::table('users')
            ->where('users.codigo_referido', $user[0]->codigo_referido_usuario)
            ->get();
        if ($emp == '[]') {
            $tienda_fav = 2;
            return $tienda_fav;
        }

        $tienda_fav = DB::table('tiendas')
            ->where('tiendas.id_propietario', $emp[0]->id)
            ->get();
        if ($tienda_fav == '[]') {
            $tienda_fav = 3;
            return $tienda_fav;
        }
        return $tienda_fav;
    }

    public function getTiendaFav($id)
    {
        $tienda_fav = $this->getTiendaFav_DB($id);
        return response()->json($tienda_fav, 200);
    }

    public function savePuntosGO($id_user)
    {

        $userPG = User::find($id_user);

        if (is_null($userPG)) {
            return response()->json([
                'message' => 'Usuario no existe.'
            ], 400);
        }

        $userPG->puntos_go += 5;
        $userPG->save();

        return response()->json([
            'message' => 'PuntosGO actualizados',
            'puntos_go' => $userPG->puntos_go,
        ], 200);
    }

    private function getDeliTop($user)
    {   
        $deliTOP = array();

        $tiendas_top = DB::table('tiendas')
        ->join('categoria_tiendas', 'tiendas.id_categoria_tienda', '=', 'categoria_tiendas.id')
        ->join('users','users.id','=', 'tiendas.id_propietario')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('users.is_plus', 1)
        ->where('tiendas.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();
        $is_tiendas_top = $this->validateQuery($tiendas_top);

        $productos_top = DB::table('productos')
        ->join('tiendas','tiendas.id','=', 'productos.id_tienda')
        ->join('users','users.id','=', 'tiendas.id_propietario')
        ->select('productos.*')
        ->where('users.is_plus', 1)
        ->where('productos.estado', 1)
        ->where('tiendas.ciudad', $user->ciudad)
        ->get();

        $is_productos_top = $this->validateQuery($productos_top);

        array_push($deliTOP, [
            'tiendas_top' => [
                'tt' => $tiendas_top,
                'status' => $is_tiendas_top
            ],
            'productos_top' => [
                'pt' => $productos_top,
                'status' => $is_productos_top
            ]
        ]);
        
        return $deliTOP;
    }

    /* Esta función es para validar la alerta esa del home (no se me ocurre otra forma de hacerlo) */
    public  function isCodRef($id_user)
    {
        $emp = DB::table('users')
        ->where('id', $id_user)
        ->update([
            'is_cod_ref' => 1  
        ]);

        return response()->json($emp, 200);
    }

    /* No pertenece al home pero lo pongo aquí para evitar conflicto */
    /* Esta función valida si ya vió el tutorial o no, para así obligar al usuario */
    public function isTutorial($id_emp){
        $emp = DB::table('users')
        ->where('id', $id_emp)
        ->update([
            'is_tutorial' => 1  
        ]);

        return response()->json($emp, 200);
    }

}
