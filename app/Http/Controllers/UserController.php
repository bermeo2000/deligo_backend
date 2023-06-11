<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Tienda;
use App\Models\User;
use App\Models\CategoriasUsuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
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

    


    


    public function register(Request $request)
    {
      /*   return response()->json(['message' => $request], 200); */
        $validateData = $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string|max:255',
            'ciudad'            => 'required|string|max:255',
            'id_codigo_pais'    => 'required',
            'id_tipo_usuario'   => 'required',
            'is_categorias_selec'=>'required',
        ]);
        
        $type=2;
        $user = User::create([
            'nombre'            =>$validateData['nombre'],
            'apellido'          =>$validateData['apellido'],
            'email'             =>$validateData['email'],
            'password'          =>$validateData['password'],
            'ciudad'            =>$validateData['ciudad'],
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

        return response()->json(['message' => 'Usuario registrado'], 200);
    }

   
}
