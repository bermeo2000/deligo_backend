<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        $query = DB::table('users')
        ->join('tipo_usuarios', 'users.id_tipo_usuario', '=', 'tipo_usuarios.id')
        ->select('users.*', 'tipo_usuarios.*')
        ->where('users.email', $user->email)
        ->get();

        if ($user->id_tipo_usuario == 3) {

            if ($user->codigo_referido_usuario == null) {
                $user->codigo_referido_usuario = '';
            }

            return response()
            ->json([
                'accesToken' => $token,
                'typeUserId' => $user->id_tipo_usuario,
                'id' => $user->id,
                'userName' => $user->nombre . ' ' . $user->apellido,
                'email' => $user->email,
                'rol' => $query[0]->tipo,
                'codigo_referido_usuario' => $user->codigo_referido_usuario,
                'puntos_go' => $user->puntos_go,
                'is_cod_ref' => $user->is_cod_ref,
                'message' => "Credenciales válidas"
            ], 200);
        }

        // * En caso de que sea emprendedor
        // ! Si es admin puede funcionar regular
        $tiendas_emp = DB::table('tiendas')
        ->select('tiendas.id as id_tienda'/* , 'tiendas.nombre_tienda', 'tiendas.imagen', 'tiendas.id_categoria_tienda' */)
        ->where('tiendas.id_propietario', $user->id,)
        ->where('tiendas.estado', 1)
        ->get();
        /* foreach ($tiendas_emp as $key => $value) {
            $detalle_ventas=DB::table('detalle_ventas')
            ->select('detalle_ventas.id_tienda',DB::raw('SUM(detalle_ventas.precio) as suma_precio'))
            ->where('detalle_ventas.id_tienda', $value->id_tienda,)
            ->where('detalle_ventas.estado', 1)
            ->groupBy('detalle_ventas.id_tienda')
            ->get();
        } */
      
        return response()
            ->json([
                'accesToken' => $token,
                'typeUserId' => $user->id_tipo_usuario,
                'id' => $user->id,
                'userName' => $user->nombre . ' ' . $user->apellido,
                'email' => $user->email,
                'rol' => $query[0]->tipo,
                'ventas'=>$user->ventas,
                /* 'ingresos'=>$detalle_ventas, */
                'id_tiendas' => $tiendas_emp,
                'codigo_referido' => $user->codigo_referido,
                'puntos_go' => $user->puntos_go,
                'is_tutorial' => $user->is_tutorial,
                'is_plus' => $user->is_plus,
                'message' => "Credenciales válidas"
            ]);

    }
}