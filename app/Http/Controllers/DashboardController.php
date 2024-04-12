<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function getDashboard($id_tienda){
        $tienda = Tienda::find($id_tienda);
        // Valida que exista la tienda
        if(!isset($tienda)){
            return response()->json([
                'message' => 'Tienda no existe.',
            ], 404);
        }
        $emprendedor = User::where('id', $tienda->id_propietario)->get();
        if(!isset($emprendedor)){
            return response()->json([
                'message' => 'Emprendedor no existe.',
            ], 404);
        }





        return response()->json([
            'tienda' => $tienda,
            'emprendedor' => $emprendedor[0],
        ], 200);

    }
}
