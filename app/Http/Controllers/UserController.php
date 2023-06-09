<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\CategoriasUsuario;

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

    public function register(Request $request)
    {
       //return response()->json($request);
        $validateData = $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string|max:255',
            'ciudad'            => 'required|string|max:255',
            'cedula'            => 'required|string|max:255',
            'telefono'          => 'required|string|max:255',
            'imagen'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_codigo_pais'    => 'required',
            'id_tipo_usuario'   => 'required',
            'is_categorias_selec'=>'required',
        ]);

        $type=2;
        //imagen
        $img=$request->file('imagen');
        $validateData['imagen'] = time().'.'.$img->getClientOriginalExtension();

        $user = User::create([
            'nombre'            =>$validateData['nombre'],
            'apellido'          =>$validateData['apellido'],
            'email'             =>$validateData['email'],
            'password'          =>$validateData['password'],
            'ciudad'            =>$validateData['ciudad'],
            'cedula'            =>$validateData['cedula'],
            'telefono'          =>$validateData['telefono'],
            'imagen'            =>$validateData['imagen'],
            'id_codigo_pais'    =>$validateData['id_codigo_pais'],
            'id_tipo_usuario'   =>$validateData['id_tipo_usuario'],
            'is_categoria_selec'=>$validateData['is_categorias_selec'],
            'estado'=>1,

          
        ]);
        
        if ($validateData['is_categorias_selec']==1) {
            $array = explode(",",$request->categorias);
            for ($i = 0; $i < count($array); $i++) {
                $aux=$array[$i];
                CategoriasUsuario::create([
                    'estado' => 1,
                    'id_usuario' => $user->id,
                    'id_categoria_tienda' => $aux,
                ]);
            }
        } 

        $request->file('imagen')->storeAs("public/images/persona/{$user->id}", $validateData['imagen']);

        return response()->json(['message' => 'Usuario registrado'], 200);
    }

    

  
}
