<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
