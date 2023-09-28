<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\ResenaProducto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResenaProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //FIXME
        // EL TEXTO NO ES OBLIGATORIO

        // TODO
        // Trabajar mucho en validaciones y manejo de errores
        // Validar que la puntuacion sea numeric
        $valid_data = $request->validate([
            'id_producto' => 'required',
            'id_user' => 'required',
            'texto' => 'required|string',
            'puntuacion_estrellas' => 'required|numeric',
        ]);
        // id_producto

        $rese_producto = ResenaProducto::create([
            'id_producto' => $valid_data['id_producto'],
            'id_user' => $valid_data['id_user'],
            'texto' => $valid_data['texto'],
            'puntuacion_estrellas' => (integer) $valid_data['puntuacion_estrellas'],
            'estado' => 1
        ]);
        $this->savePuntuacionProducto($valid_data['id_producto']);
        return response()->json(['message' => 'Reseña del producto guardada'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_rese_producto)
    {
        // Obtiene una reseña de producto en especifico sin tener en cuenta la tienda
        $rese_producto = ResenaProducto::find($id_rese_producto);
        return response()->json($rese_producto, 200);
        // validación aquí?
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResenaProducto $resenaProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Actualiza una reseña en especifico
        $rese_producto_up = ResenaProducto::find($id);
        if(is_null($rese_producto_up)){
            return response()->json(['message' => 'Reseña del producto no existe'], 404);
        }
        $valid_data = $request->validate([
            'id_producto' => 'required',
            'id_user' => 'required',
            'texto' => 'required|string',
            'puntuacion_estrellas' => 'required|numeric',
        ]);
        $rese_producto_up->id_producto = $valid_data['id_producto'];
        $rese_producto_up->id_user = $valid_data['id_user'];
        $rese_producto_up->texto = $valid_data['texto'];
        $rese_producto_up->puntuacion_estrellas = $valid_data['puntuacion_estrellas'];
        $rese_producto_up->save();
        $this->savePuntuacionProducto($valid_data['id_producto']);
        return response()->json(['message' => 'Reseña del producto actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Este método "desactiva una reseña", desde front se debe validar que
        // el usuario solo elimine sus propias reseñas
        $rese_producto_des = ResenaProducto::find($id);
        if(is_null($rese_producto_des)){
            return response()->json(['message' => 'Reseña de la tienda no existe'], 404);
        }
        $rese_producto_des->estado = 0;
        $rese_producto_des->save();

        return response()->json(['message' => 'Reseña de la tienda eliminada'], 200);
    }

    public function getReseProductoByUsuario($id_user)
    {
        // Este método busca las reseñas de producto por usuario
        $user = User::find($id_user);
        if(is_null($user)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_producto_user = DB::table('resena_productos')
        ->where('resena_productos.id_user', $user->id)
        ->where('resena_productos.estado', 1)
        ->get();

        return response()->json($rese_producto_user, 200);
    }

    public function getReseProductoByProducto($id_producto)
    {
        // Este método busca las reseñas de tienda por tienda
        $producto = Producto::find($id_producto);
        if(is_null($producto)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_producto_producto = $this->getReseProductoByProducto_DB($producto);
        return response()->json($rese_producto_producto, 200);
    }

    private function getReseProductoByProducto_DB($producto)
    {
        $rese_producto_producto = DB::table('resena_productos')
        ->where('resena_productos.id_producto', $producto->id)
        ->where('resena_productos.estado', 1)
        ->get();
        return $rese_producto_producto;
    }

    private function savePuntuacionProducto($id_producto)
    {
        // Esta función calcula la puntuación final de la tienda (promedio)
        // lo hace consultando las reseñas sumando las puntuaciones y dividiendo para el total
        $producto = Producto::find($id_producto);
        if(is_null($producto)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_producto_producto = $this->getReseProductoByProducto_DB($producto);

        $sum = 0;
        $len = 0;
        foreach ($rese_producto_producto as $rtt) {
            $sum += $rtt->puntuacion_estrellas;
            $len++;
        }
        $promedio = $sum / $len;
        $producto->puntuacion = (float) $promedio;
        $producto->save();
    }
}
