<?php

namespace App\Http\Controllers;

use App\Models\PromocionProducto;
use Illuminate\Http\Request;

class PromocionProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promocionproducto = PromocionProducto::where('estado',1) ->get();
        if (count($promocionproducto)==0) {
            return response()-> json('no existen marca promoción producto',404);
        }
        return response()->json($promocionproducto,200);
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
/*         $validateData=$request->validate([
            'id_producto' =>'required',
            'descuento'=>'required',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'nullable|date',

        ]);
        $promocionproducto = PromocionProducto::create([
            'id_producto' => $validateData['id_producto'],
            'descuento' => $validateData['descuento'],
            'fecha_inicio' => $validateData['fecha_inicio'],
            'fecha_fin' => $validateData['fecha_fin'],
            'estado' => 1,
        ]);

        return response()->json(['message' => 'promocionproducto registrada correctamente'], 200);
 */
        
        $idProducto=$request->id_producto;
        $promocionproductos=json_decode($request->promocionproductos,true);
        $aux= count($promocionproductos);
        for ($i=0; $i < $aux ; $i++) 
        { 
            $aux2=$promocionproductos[$i];
            $promocionproducto=PromocionProducto::create([
                'id_producto' => $idProducto,
                'descuento' => $aux2['descuento'],
                'fecha_inicio' => $aux2['fecha_inicio'],
                'fecha_fin' => $aux2['fecha_fin'],
                'estado' => 1
                ]);
        }       

        return response()->json(['message'=>'promocion producto registrada'], 200); 
    }

    /**
     * Display the specified resource.
     */
    public function show(PromocionProducto $id)
    {
        $promocionproducto=PromocionProducto::find($id);
        if (is_null($promocionproducto)) {
            return response()->json(['message' => 'promocionproducto no encontrado'], 404);
        }
        return response()->json($promocionproducto);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromocionProducto $promocionProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_promocionProducto)
    {
        $promocionproducto = PromocionProducto::find($id_promocionProducto);
        if (is_null($id_promocionProducto)) {
            return response()->json(['message' => 'promocion producto no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'id_producto' =>'required',
            'descuento'=>'required',
            'fecha_inicio'=>'required|date',
            'fecha_fin'=>'required|date',
        ]);
        $promocionproducto->id_producto = $validateData['id_producto'];
        $promocionproducto->descuento = $validateData['descuento'];
        $promocionproducto->fecha_inicio = $validateData['fecha_inicio'];
        $promocionproducto->fecha_fin = $validateData['fecha_fin'];
        $promocionproducto->save();
        return response()->json(['message' => 'promocion producto actualizado'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_promocionProducto)
    {
        $promocionProducto=PromocionProducto::find($id_promocionProducto);
        if (is_null($promocionProducto)) {
            return response()->json(['message' => 'promocion producto no encontrada'], 404);
        }
        $promocionProducto->estado = 0;
        $promocionProducto->save();
       return response()->json("La promocion productos se elimino con exito", 200);
    }
}
