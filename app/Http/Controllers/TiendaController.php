<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use App\Models\CategoriasUsuario;
use Illuminate\Http\Request;

class TiendaController extends Controller
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
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Tienda $tienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tienda $tienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tienda $tienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tienda $tienda)
    {
        //
    }

    public function storeEmprendedor(Request $request){
        $validateData=$request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'email'             => 'required|string|max:255',
            'password'           => 'required|string|max:255',
            'ciudad'            => 'required|string|max:255',
            'cedula'            => 'required|string|max:255',
            'telefono'          => 'required|string|max:255',
            'imagen'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_codigo_pais'    => 'required',
            'id_tipo_usuario'   => 'required',
            'is_categorias_selec'=>'required',
        ]);
        if (isset($validatedData['imagen'])) {
            $img = $request->file('imagen');
            $validatedData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validatedData['imagen'] = null;
        }


        $usuario=User::create([
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
                    'id_usuario' => $usuario->id,
                    'id_categoria_tienda' => $aux,
                ]);
            }
        } 
       
        return response()->json("funciono");


    }

    public function storeTienda($request, $usuario){
        $validateData=$request->validate([
            'nombre_tienda'            => 'required|string|max:255',
            'id_categoria_tienda'      => 'required',
            'ciudad'                   => 'required|string|max:255',
            'direccion'                => 'required|string|max:255',
            'celular'                  => 'required|string|max:255',
            'id_codigo_pais'           => 'required',
            'instagram_user'           => 'nullable|string|max:255',
            'facebook_user'            => 'nullable|string|max:255',
            'tiktok_user'              => 'nullable|string|max:255',
            'lat'                      => 'required',
            'lng'                      => 'required',
            'is_delivery'              => 'required',
            'cargo_delivery'           => 'nullabe',
            'tiempo_delivery_min'      => 'nullable',
            'puntuacion'               => 'required',
            'descripcion'              => 'nullable'

        ]);

    }
}
