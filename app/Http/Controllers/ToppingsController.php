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
        // * No se usa
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

    public function saveTopping(Request $request){
        $validData = $request->validate([
            'descripcion' => 'required',
            'id_tienda' => 'required',
            'precio' => 'nullable'
        ]);
        
        $topping = Toppings::create([
            'descripcion' => $validData['descripcion'],
            'id_tienda' => $validData['id_tienda'],
            'imagen' => null,
            'precio' => $validData['precio'],
            'estado' => 1
        ]);

        return response()->json([
            'message' => 'Adicional creado con éxito.',
            'data' => $topping
        ], 200);
    }
    
    
    // Guarda los que vienen en array
    public function store(Request $request)
    {
        $idTienda=$request->id_tienda;
        $toppings=json_decode($request->toppings,true);
        $aux= count($toppings);
        for ($i=0; $i < $aux ; $i++) 
        { 
            $aux2=$toppings[$i];
            $topping = Toppings::create([
                'descripcion' => $aux2['descripcion'],
                'precio' => $aux2['precio'],
                'id_tienda' => $idTienda,
                'estado' => 1
            ]);
        }       

        return response()->json(['message'=>'toppings registrada'], 200);
    }

    public function show($id)
    {
        $toppings=Toppings::find($id);
        if (is_null($toppings)) {
            return response()->json(['message' => 'toppings no encontrado'], 404);
        }
        return response()->json($toppings);
    }

    public function edit(Toppings $toppings)
    {
        //
    }

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

        $validateData['imagen'] = $request->file('imagen')->storePublicly("public/images/toppings");
        $toppings->imagen=$validateData['imagen'];
        $toppings->save();
        return response()->json(['message' => 'Foto de toppings actualizada'], 201);
    }


    public function getToppingsByTienda($id){
        $toppings = Toppings::where('id_tienda',$id)
        ->where('estado',1) 
        ->get();
        if (count($toppings)==0) {
            return response()-> json('no existen toppings',404);
        }
        return response()->json($toppings,200);
    }

}
