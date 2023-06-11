<?php

namespace App\Http\Controllers;

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
          
             return response()->json(
                [
                    'accesToken'=>$token,
                    'tokenType'=>'Bearer',
                    'typeUserId'=>$user->id_tipo_usuario,
                    'id'=>$user->id,
                    'userName'=>$user->name,
                    'email'=>$user->email,
                    'rol'=>$query[0]->tipo,          
                    'message' => "Credenciales válidas"
                ],
                200
    
            );
        
    }

    /* public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401); 
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('auth_token')->plainTextToken;

        $res = DB::table('users')
            ->join('tipo_usuarios', 'users.id_tipo_usuario', '=', 'tipo_usuarios.id')
            ->select('users.*', 'tipo_usuarios.*')
            ->where('users.email', $user->email)
            ->get();

            return response()->json(
                [
                    'accesToken' => $token,
                    'tokenType' => 'Bearer',
                    'typeUserId' => $user->id_tipo_usuario,
                    'id' => $user->id,
                    'userName' => $user->nombre,
                    'email' => $user->email,
                    'rol' => $res[0]->tipo,
                    'message' => "Credenciales válidas"
                ], 200
    
            );
    } */
}

    /* public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $users = User::where('email', $request->email)->first();

        $token = $users->createToken('auth_token')->plainTextToken;

        $res = DB::table('users')
        ->join('tipo_usuarios', 'users.id_tipo_usuario', '=', 'tipo_usuarios.id')
        ->select('users.*', 'tipo_usuarios.*')
        ->where('users.email', $users->email)
        ->get();

        return response()->json(
            [

                'accesToken' => $token,
                'tokenType' => 'Bearer',
                'typeUserId' => $users->id_tipo_users,
                'id' => $users->id,
                'userName' => $users->nombre,
                'email' => $users->email,
                'rol' => $res[0]->tipo,
                'message' => "Credenciales válidas"

            ], 200

        );

    }

} */

