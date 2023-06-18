<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $marca = Marca::where('estado',1) ->get();
        if (count($marca)==0) {
            return response()-> json('no existen marca',404);
        }
        return response()->json($marca,200);
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
        $validateData=$request->validate([
            'descripcion'=>'required|string|max:255',
            'imagen' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_tienda' =>'required',
        ]);
        //imagen
        $img = $request->file('imagen');
        $valiData['imagen'] =  time().'.'.$img->getClientOriginalExtension();
        $marca=Marca::create([
            'descripcion'=>$validateData['descripcion'],
            'imagen'=>$valiData['imagen'],
            'id_tienda'=>$validateData['id_tienda'],
            'estado'=>1,
        ]);

        $request->file('imagen')->storeAs("public/images/marca/{$marca->id}", $valiData['imagen']);
        return response()->json(['message'=>'Marca registrada'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $marca=DB::table('marcas')
        ->join('tiendas','marcas.id_tienda','=','tiendas.id')
        ->select('marcas.*')
        ->where('marcas.estado',1)
        ->where('marcas.id_tienda',$id)
        ->orWhere('marcas.id_tienda',1)
        ->get();
        if (count($marca)== 0) {
            return response()->json(['message' => 'marca no encontrado'], 404);
        }
        return response()->json($marca);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marca = Marca::find($id);
        if (is_null($marca)) {
            return response()->json(['message' => 'marca no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'descripcion'=>'required|string|max:255',
            'id_tienda' =>'required',
            
        ]);
        $marca->descripcion = $validateData['descripcion'];
        $marca->id_tienda = $validateData['id_tienda'];
        $marca->save();
        return response()->json(['message' => 'marca actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marca=Marca::find($id);
        if (is_null($marca)) {
            return response()->json(['message' => 'Marca no encontrada'], 404);
        }
        $marca->estado = 0;
        $marca->save();
        return response()->json(['message'=>'Marca eliminada']);
    }


    public function editImagen(Request $request, $id ){

        $marca = Marca::find($id);
        if (is_null($marca)) {
            return response()->json(['message' => 'marca no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'imagen' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('imagen');
        $validateData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('imagen')->storeAs("public/images/marca/{$marca->id}", $validateData['imagen']);
        $marca->imagen=$validateData['imagen'];
        $marca->save();
        return response()->json(['message' => 'Foto de marca actualizada'], 201);
    }

}
