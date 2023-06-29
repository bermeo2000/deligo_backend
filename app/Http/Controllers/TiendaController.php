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
    public function show( $id)
    {
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['mesagge'=>'No se encontro ninguna tienda',400]);
        }
        return response()->json($tienda);
        
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
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda',404]);
        }
        $validateDataTienda=$request->validate([
            'nombre_tienda'            => 'required|string|max:255',
            'ciudad'             => 'required|string|max:255',
            'direccion'                => 'nullable|string|max:255',
            'celular'                  => 'required|string|max:255',
            'descripcion'              => 'nullable',
            'lat'                      =>'nullable',
            'lng'                      =>'nullable',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message'=>'Datos de tienda actualizados con exito'],200);
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
        $request->file('imagen')->storeAs("public/images/usuario/{$usuario->id}", $validateData['imagen']);

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
       $this->storeTienda($request,$usuario);
        return response()->json("funciono");

        

    }

    public function storeTienda($request, $usuario){
        $validateDataTienda=$request->validate([
            'nombre_tienda'            => 'required|string|max:255',
            'id_categoria_tienda'      => 'required',
            'ciudadTienda'             => 'required|string|max:255',
            'direccion'                => 'nullable|string|max:255',
            'celular'                  => 'required|string|max:255',
            'id_codigo_pais_tienda'    => 'required',
            'instagram_user'           => 'nullable|string|max:255',
            'facebook_user'            => 'nullable|string|max:255',
            'tiktok_user'              => 'nullable|string|max:255',
            'lat'                      => 'nullable',
            'lng'                      => 'nullable',
            'is_delivery'              => 'required',
            'cargo_delivery'           => 'nullable',
            'tiempo_delivery_min'      => 'nullable',
            'puntuacion'               => 'required',
            'descripcion'              => 'nullable',
            'imagen_tienda'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ]);
        if (isset($validatedDataTienda['imagen_tienda'])) {
            $img = $request->file('imagen_tienda');
            $validatedDataTienda['imagen_tienda'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validatedDataTienda['imagen_tienda'] = null;
        }
        
        $tienda=Tienda::create([
            'nombre_tienda'            =>$validateDataTienda['nombre_tienda'],
            'id_propietario'           =>$usuario->id,
            'id_categoria_tienda'      =>$validateDataTienda['id_categoria_tienda'],
            'ciudad'                   =>$validateDataTienda['ciudadTienda'],
            'direccion'                =>$validateDataTienda['direccion'],
            'celular'                  =>$validateDataTienda['celular'],
            'id_codigo_pais'           =>$validateDataTienda['id_codigo_pais_tienda'],
            'instagram_user'           =>$validateDataTienda['instagram_user'],
            'facebook_user'            =>$validateDataTienda['facebook_user'],
            'tiktok_user'              =>$validateDataTienda['tiktok_user'],
            'lat'                      =>$validateDataTienda['lat'],
            'lng'                      =>$validateDataTienda['lng'],
            'is_delivery'              =>$validateDataTienda['is_delivery'],
            'cargo_delivery'           =>$validateDataTienda['cargo_delivery'],
            'tiempo_delivery_min'      =>$validateDataTienda['tiempo_delivery_min'],
            'puntuacion'               =>$validateDataTienda['puntuacion'],
            'descripcion'              =>$validateDataTienda['descripcion'],
            'imagen'                   =>$validatedDataTienda['imagen_tienda'],
            'estado'=>1,
        ]);
        
       $request->file('imagen')->storeAs("public/images/tienda/{$tienda->id}", $validatedDataTienda['imagen_tienda']);
    }

    public function Updatefototienda(Request $request, $id){
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda',404]);
        }
        $validateData=$request->validate(
            ['imagen'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',]
        );
        if (isset($validatedData['imagen'])) {
            $img = $request->file('imagen');
            $validatedData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validatedData['imagen'] = null;
        }
        $tienda->imagen = $validatedData['imagen'];
        $tienda->save();
        $request->file('imagen')->storeAs("public/images/marca/{$marca->id}", $valiData['imagen']);
        return response()->json(['message'=>'La foto se actualizo con exito'],200);
    }

    public function updateRedes(Request $request, $id){
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda'],404);
        }
        $validateDataTienda=$request->validate([
            'instagram_user'           =>'nullable|string|max:255',
            'facebook_user'            =>'nullable|string|max:255',
            'tiktok_user'              =>'nullable|string|max:255',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message'=>'Las redes sociales se actualizaron de manera exitosa'],200);
    }

    public function updateDelivery(Request $request, $id){
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda'],404);
        }
        $validateDataTienda=$request->validate([
            'is_delivery'              => 'required',
            'cargo_delivery'           => 'nullable',
            'tiempo_delivery_min'      => 'nullable',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message'=>'Las funciones de delivery se actualizaron de manera exitosa'],200);
    }


}
