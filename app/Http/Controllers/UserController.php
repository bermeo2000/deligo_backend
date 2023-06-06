<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('estado',1)->get();
        return response()->json($user, 200);
    }
    
    public function register(Request $request)
    {
       //return response()->json($request);
        $validData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'ciudad'=>'required|string|max:255',
            'cedula'=>'required|string|max:10',
            'telefono'=>'required|string',
            'id_tipo_usuario'=>'required',
            'is_categorias_selec'=>'required',
            'id_codigo_pais'=>'required',

           
            'imagen'=>'required'
        ]);

        //imagen
        $img=$request->file('imagen');
        $validData['imagen'] = time().'.'.$img->getClientOriginalExtension();

        $user = User::create([
            'nombre' => $validData['nombre'],
            'apellido' => $validData['apellido'],
            'email' => $validData['email'],
            'password' => Hash::make($validData['password']),
            'ciudad' => $validData['ciudad'],
            'cedula' => $validData['cedula'],
            'telefono' => $validData['telefono'],
          
            'imagen' => $validData['imagen'],
            'estado' => 1,
            'id_tipo_usuario' => $validData['id_tipo_usuario'],
            'is_categorias_selec' => $validData['is_categorias_selec'],
            'id_codigo_pais' => $validData['id_codigo_pais'],
        ]);


        $request->file('imagen')->storeAs("public/images/persona/{$user->id}", $validData['imagen']);

        return response()->json(['message' => 'Usuario registrado'], 200);
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
