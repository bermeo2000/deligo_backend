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
            'precio' =>'required',
            'id_tienda' =>'required',
        ]);

        $toppings=Toppings::create([
            'descripcion'=>$validateData['descripcion'],
            'precio'=>$validateData['precio'],
            'id_tienda'=>$validateData['id_tienda'],
            'estado'=>1,
        ]);
        if($toppings->is_topping==1){
            $this->storeTopping($request,$toppings->id,$toppings->id_tienda);
    
        }

        return response()->json(['message'=>'toppings registrada'], 200);
    }


    
    public function storeTopping($request)
    {
        $toppings=json_decode($request->toppings,true);
        $aux= count($toppings);
        for ($i=0; $i < $aux ; $i++) 
        { 
            $aux2=$toppings[$i]; 
            {
                 return response()
                        ->json([
                        'message' => 'El producto o la tienda no existen.',
                        /* 'data' => '', */
                         ], 400);
            }
        }       
    }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $toppings=Toppings::find($id);
        if (is_null($toppings)) {
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
    public function destroy($id_toppings)
    {
        $toppings=Toppings::find($id_toppings);
        if (is_null($toppings)) {
            return response()->json(['message' => 'toppings no encontrada'], 404);
        }
        $toppings->estado = 0;
        $toppings->save();
        return response()->json("el toppings se elimino con exito", 200);
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
