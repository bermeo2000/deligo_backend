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
            return response()
                ->json([
                    'accesToken' => $token,
                    /* 'tokenType'=>'Bearer', */
                    'typeUserId' => $user->id_tipo_usuario,
                    'id' => $user->id,
                    'userName' => $user->nombre . ' ' . $user->apellido,
                    'email' => $user->email,
                    'rol' => $query[0]->tipo,
                    'message' => "Credenciales válidas"

                ], 200);
        }

        //en este caso no es  un usuario normal 
        // es un emprendedor o un admin

        $tiendas_emp = DB::table('tiendas')
            ->select('tiendas.id as id_tienda', 'tiendas.nombre_tienda')
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
                'message' => "Credenciales válidas"
            ]);
        
        //tener en cuenta que puede tener mas de una tienda y pensar en como se va a manejar eso
        //TODO
        /* 
            hacer un seeder de tienda
            ver que funcione con mas de una tienda para el mismo usuario y agregar un pantala adicional
        */
    }
}