<?php

namespace App\Http\Controllers;

use App\Models\ResenaTienda;
use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResenaTiendaController extends Controller
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
        // TODO
        // Trabajar mucho en validaciones y manejo de errores
        // Validar que la puntuacion sea numeric
        $valid_data = $request->validate([
            'id_tienda' => 'required',
            'id_user' => 'required',
            'texto' => 'required|string',
            'puntuacion_estrellas' => 'required|numeric',
        ]);

        $rese_tienda = ResenaTienda::create([
            'id_tienda' => $valid_data['id_tienda'],
            'id_user' => $valid_data['id_user'],
            'texto' => $valid_data['texto'],
            'puntuacion_estrellas' => (integer) $valid_data['puntuacion_estrellas'],
            'estado' => 1
        ]);
        $this->savePuntuacionTienda($valid_data['id_tienda']);
        return response()->json(['message' => 'Reseña de la tienda guardada'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id_rese_tienda)
    {
        // Obtiene una reseña en especifico sin tener en cuenta la tienda
        $rese_tienda = ResenaTienda::find($id_rese_tienda);
        return response()->json($rese_tienda, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResenaTienda $resenaTienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Actualiza una reseña en especifico
        $rese_tienda_up = ResenaTienda::find($id);
        if(is_null($rese_tienda_up)){
            return response()->json(['message' => 'Reseña de la tienda no existe'], 404);
        }
        $valid_data = $request->validate([
            'id_tienda' => 'required',
            'id_user' => 'required',
            'texto' => 'required|string',
            'puntuacion_estrellas' => 'required|numeric',
        ]);
        $rese_tienda_up->id_tienda = $valid_data['id_tienda'];
        $rese_tienda_up->id_user = $valid_data['id_user'];
        $rese_tienda_up->texto = $valid_data['texto'];
        $rese_tienda_up->puntuacion_estrellas = $valid_data['puntuacion_estrellas'];
        $rese_tienda_up->save();
        $this->savePuntuacionTienda($valid_data['id_tienda']);
        return response()->json(['message' => 'Reseña de la tienda actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Este método "desactiva una reseña", desde front se debe validar que
        // el usuario solo elimine sus propias reseñas
        $rese_tienda_des = ResenaTienda::find($id);
        if(is_null($rese_tienda_des)){
            return response()->json(['message' => 'Reseña de la tienda no existe'], 404);
        }
        $rese_tienda_des->estado = 0;
        $rese_tienda_des->save();

        return response()->json(['message' => 'Reseña de la tienda eliminada'], 200);
    }

    public function getReseTiendaByUsuario($id_user)
    {
        // Este método busca las reseñas de tienda por usuario
        $user = User::find($id_user);
        if(is_null($user)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_tienda_user = DB::table('resena_tiendas')
        ->where('resena_tiendas.id_user', $user->id)
        ->where('resena_tiendas.estado', 1)
        ->get();

        return response()->json($rese_tienda_user, 200);
    }

    public function getReseTiendaByTienda($id_tienda)
    {
        // Este método busca las reseñas de tienda por tienda
        $tienda = Tienda::find($id_tienda);
        if(is_null($tienda)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_tienda_tienda = $this->getReseTiendaByTienda_DB($tienda);
        return response()->json($rese_tienda_tienda, 200);
    }

    private function getReseTiendaByTienda_DB($tienda)
    {
        $rese_tienda_tienda = DB::table('resena_tiendas')
        ->where('resena_tiendas.id_tienda', $tienda->id)
        ->where('resena_tiendas.estado', 1)
        ->get();
        return $rese_tienda_tienda;
    }

    private function savePuntuacionTienda($id_tienda)
    {
        // Esta función calcula la puntuación final de la tienda (promedio)
        // lo hace consultando las reseñas sumando las puntuaciones y dividiendo para el total
        $tienda = Tienda::find($id_tienda);
        if(is_null($tienda)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_tienda_tienda = $this->getReseTiendaByTienda_DB($tienda);

        $sum = 0;
        $len = 0;
        foreach ($rese_tienda_tienda as $rtt) {
            $sum += $rtt->puntuacion_estrellas;
            $len++;
        }
        $promedio = $sum / $len;
        $tienda->puntuacion = (float) $promedio;
        $tienda->save();
    }




}
