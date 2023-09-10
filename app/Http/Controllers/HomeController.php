<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTienda;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // En este controller estan presentes las consultas para el home
    // con el fin de optimizar y hacer una sola petición
    
    public function getHome(){
        $home = Array();

        $tiendas=DB::table('tiendas')
        ->join('categoria_tiendas','tiendas.id_categoria_tienda','=','categoria_tiendas.id')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('tiendas.estado',1)
        ->get();
        $categoria_tiendas = CategoriaTienda::where('estado',1)->get();
        $productos = Producto::where('estado',1)->get();

        array_push(
            $home, [
                'categoria_tiendas' => $categoria_tiendas,
                'tiendas' => $tiendas,
                'productos' => $productos,
            ]
        );

        return response()->json($home, 200);
    }

    public function saveReferidoUsuario(Request $request){
        $validData = $request->validate([
            'id_user' => 'required',
            'codigo_referido_usuario' => 'required'
        ]);

        $user_ref = User::find($validData['id_user']);
        if (is_null($user_ref)) {
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }
        $user_ref->codigo_referido_usuario = $validData['codigo_referido_usuario'];
        $user_ref->save();
        return response()->json(['message' => 'Referido de usuario guardado correctamente'], 200);
    }

}
