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
                    /* 'tokenType'=>'Bearer', */
                    'typeUserId' => $user->id_tipo_usuario,
                    'id' => $user->id,
                    'userName' => $user->nombre . ' ' . $user->apellido,
                    'email' => $user->email,
                    //se quita porque en caso de un usuario normal no va a tener nunca
                    /* 'codigo_referido'=>$user->codigo_referido, */
                    'rol' => $query[0]->tipo,
                    'codigo_referido_usuario' => $user->codigo_referido_usuario,
                    'puntos_go' => $user->puntos_go,
                    /* El usuario normal solo necesita la confirmación de cod ref */
                    'is_cod_ref' => $user->is_cod_ref,
                    'message' => "Credenciales válidas"

                ], 200);
        }

        //en este caso no es  un usuario normal 
        // es un emprendedor o un admin

        $tiendas_emp = DB::table('tiendas')
        ->select('tiendas.id as id_tienda', 'tiendas.nombre_tienda', 'tiendas.imagen')
        ->where('tiendas.id_propietario', $user->id)
        ->where('tiendas.estado', 1)
        ->get();

        return response()
            ->json([
                'accesToken' => $token,
                'typeUserId' => $user->id_tipo_usuario,
                'id' => $user->id,
                'userName' => $user->nombre . ' ' . $user->apellido,
                'email' => $user->email,
                'rol' => $query[0]->tipo,
                'id_tiendas' => $tiendas_emp,
                'codigo_referido' => $user->codigo_referido,
                'puntos_go' => $user->puntos_go,
                'is_tutorial' => $user->is_tutorial,
                'message' => "Credenciales válidas"
            ]);

    }
}