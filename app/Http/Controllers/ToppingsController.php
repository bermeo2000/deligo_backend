<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tienda;
use App\Models\Toppings;
use App\Models\ToppingsProductos;
use Illuminate\Http\Request;

class ToppingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   

        //la idea de esto es que el emprendedor pueda 
        //ver todos los toppings que tiene asi en general
    public function index()
    {
        
        $toppings = Toppings::where('estado',1) ->get();
        if (count($toppings)==0) {
            return response()-> json('no existen toppings',404);
        }
        return response()->json($toppings,200);
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
            'precio' =>'required',
            'id_tienda' =>'required',
        ]);
        //imagen
        $img = $request->file('imagen');
        $valiData['imagen'] =  time().'.'.$img->getClientOriginalExtension();
        $toppings=Toppings::create([
            'descripcion'=>$validateData['descripcion'],
            'imagen'=>$valiData['imagen'],
            'precio'=>$validateData['precio'],
            'id_tienda'=>$validateData['id_tienda'],
            'estado'=>1,
        ]);

        $request->file('imagen')->storeAs("public/imagen/toppings/{$toppings->id}", $valiData['imagen']);
        return response()->json(['message'=>'toppings registrada'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toppings=DB::table('toppings')
        ->join('tiendas','toppings.id_tienda','=','tiendas.id')
        ->select('toppings.*')
        ->where('toppings.estado',1)
        ->where('toppings.id_tienda',$id)
        ->orWhere('toppings.id_tienda',1)
        ->get();
        if (count($toppings)== 0) {
            return response()->json(['message' => 'toppings no encontrado'], 404);
        }
        return response()->json($toppings);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Toppings $toppings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $toppings = Toppings::find($id);
        if (is_null($toppings)) {
            return response()->json(['message' => 'toppings no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'descripcion'=>'required|string|max:255',
            'id_tienda' =>'required',
            'precio' =>'required',
        ]);
        $toppings->descripcion = $validateData['descripcion'];
        $toppings->id_tienda = $validateData['id_tienda'];
        $toppings->precio = $validateData['precio'];
        $toppings->save();
        return response()->json(['message' => 'toppings actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $toppings=Toppings::find($id);
        if (is_null($toppings)) {
            return response()->json(['message' => 'toppings no encontrada'], 404);
        }
        $toppings->estado = 0;
        $toppings->save();
        return response()->json(['message'=>'toppings eliminada']);
    }


    public function editImagen(Request $request, $id ){
        $toppings = Toppings::find($id);
        if (is_null($toppings)) {
            return response()->json(['message' => 'toppings no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'imagen' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('imagen');
        $validateData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('imagen')->storeAs("public/images/toppings/{$toppings->id}", $validateData['imagen']);
        $toppings->imagen=$validateData['imagen'];
        $toppings->save();
        return response()->json(['message' => 'Foto de toppings actualizada'], 201);
    }

}
