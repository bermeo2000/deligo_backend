<?php

namespace App\Http\Controllers;

use App\Models\ResenaServicio;
use App\Models\ProductoServicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResenaServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            'id_producto_servicio' => 'required',
            'id_user' => 'required',
            'texto' => '',
            'puntuacion_estrellas' => 'required|numeric',
        ]);
        // id_producto

        $resena_servicio = ResenaServicio::create([
            'id_producto_servicio' => $valid_data['id_producto_servicio'],
            'id_user' => $valid_data['id_user'],
            'texto' => $valid_data['texto'],
            'puntuacion_estrellas' => (integer) $valid_data['puntuacion_estrellas'],
            'estado' => 1
        ]);
        $this->savePuntuacionServicio($valid_data['id_producto_servicio']);
        return response()->json(['message' => 'Reseña del servicio guardada'], 200);
    }

  

    public function show($id_rese_servicio)
    {
        // Obtiene una reseña de producto en especifico sin tener en cuenta la tienda
        $resenaServicio = ResenaServicio::find($id_rese_servicio);
        return response()->json($resenaServicio, 200);
        // validación aquí?
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResenaServicio $resenaServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Actualiza una reseña en especifico
        $resenaServicio = ResenaServicio::find($id);
        if(is_null($resenaServicio)){
            return response()->json(['message' => 'Reseña del servicio no existe'], 404);
        }
        $valid_data = $request->validate([
            'id_producto_servicio' => 'required',
            'id_user' => 'required',
            'texto' => '',
            'puntuacion_estrellas' => 'required|numeric',
        ]);
        $resenaServicio->id_producto_servicio = $valid_data['id_producto_servicio'];
        $resenaServicio->id_user = $valid_data['id_user'];
        $resenaServicio->texto = $valid_data['texto'];
        $resenaServicio->puntuacion_estrellas = $valid_data['puntuacion_estrellas'];
        $resenaServicio->save();
        $this->savePuntuacionServicio($valid_data['id_producto_servicio']);
        return response()->json(['message' => 'Reseña del servicio actualizada'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Este método "desactiva una reseña", desde front se debe validar que
        // el usuario solo elimine sus propias reseñas
        $resenaServicio = ResenaServicio::find($id);
        if(is_null($resenaServicio)){
            return response()->json(['message' => 'Reseña del servicio no existe'], 404);
        }
        $resenaServicio->estado = 0;
        $resenaServicio->save();

        return response()->json(['message' => 'Reseña del servicio eliminada'], 200);
    }



    public function getReseServicioByUsuario($id_user)
    {
        // Este método busca las reseñas de producto por usuario
        $user = User::find($id_user);
        if(is_null($user)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_servicio_user = $this->getReseServicioByUsuario_DB($user);

        return response()->json($rese_servicio_user, 200);
    }

    private function getReseServicioByUsuario_DB($user)
    {
        $rese_servicio_user = DB::table('resena_servicios')
        ->where('resena_servicios.id_user', $user->id)
        ->where('resena_servicios.estado', 1)
        ->get();
        return $rese_servicio_user;
    }


    public function getReseServicioByServicio($id_producto_servicio)
    {
        // Este método busca las reseñas de tienda por tienda
        $productoServicio = ProductoServicio::find($id_producto_servicio);
        if(is_null($productoServicio)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_producto_servicio = $this->getReseServicioByProducto_DB($productoServicio);
        return response()->json($rese_producto_servicio, 200);
    }



    private function getReseServicioByProducto_DB($productoServicio)
    {
        $rese_producto_servicio = DB::table('resena_servicios')
        ->where('resena_servicios.id_producto_servicio', $productoServicio->id)
        ->where('resena_servicios.estado', 1)
        ->get();
        return $rese_producto_servicio;
    }


    private function savePuntuacionServicio($id_producto_servicio)
    {
        // Esta función calcula la puntuación final de la tienda (promedio)
        // lo hace consultando las reseñas sumando las puntuaciones y dividiendo para el total
        $productoServicio = ProductoServicio::find($id_producto_servicio);
        if(is_null($productoServicio)){
            return response()->json(['message' => 'Usuario no Encontrado'], 404);
        }
        $rese_producto_servicio = $this->getReseServicioByProducto_DB($productoServicio);

        $sum = 0;
        $len = 0;
        foreach ($rese_producto_servicio as $rps) {
            $sum += $rps->puntuacion_estrellas;
            $len++;
        }
        $promedio = $sum / $len;
        $productoServicio->puntuacion = (float) $promedio;
        $productoServicio->save();
    }

    public function initResePage($id_servicio, $id_user)
    {
        $servicio = ResenaServicio::find($id_servicio);
        if(is_null($servicio)){
            return response()->json(['message' => 'Servicio no encontrado'], 404);
        }
        $user = User::find($id_user);
        if(is_null($user)){
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $rese_servicios_all = $this->getReseServicioAllExclude($servicio, $user);
        if($rese_servicios_all == '[]'){
            $rese_servicios_all = false;
        }

        $rese_servicio_user = $this->getReseServicioUser($servicio, $user);
        if($rese_servicio_user == '[]'){
            $rese_servicio_user = false;
        }

        return response()->json(
            ['data' => [
                'rese_all' => $rese_servicios_all,
                'rese_user' => $rese_servicio_user
            ]], 200
        );
    }

    private function getReseTiendaUser($servicio, $user){
        //este metodo busca la reseña del usuario en esa tienda
        //el usuario solo podrá tener una reseña
        $rese_servicio_user = DB::table('resena_servicios')
        ->join('users', 'resena_servicios.id_user', '=', 'users.id')
        ->select('resena_servicios.*', 'users.nombre as user_nombre', 'users.apellido as user_apellido')
        ->where('resena_servicios.id_tienda', $servicio->id)
        ->where('resena_servicios.id_user', $user->id)
        ->where('resena_servicios.estado', 1)
        ->get();
        return $rese_servicio_user;
    }
    
    private function getReseTiendaAllExclude($servicio, $user)
    {
        // excluye la reseña del usuario activo
        $rese_servicio_servicio = DB::table('resena_servicios')
        ->join('users', 'resena_servicios.id_user', '=', 'users.id')
        ->select('resena_servicios.*', 'users.nombre as user_nombre', 'users.apellido as user_apellido')
        ->where('resena_servicios.id_tienda', $servicio->id)
        ->where('resena_servicios.estado', 1)
        ->where('resena_servicios.id_user', '!=', $user->id)
        ->get();
        return $rese_servicio_servicio;
    }


}
