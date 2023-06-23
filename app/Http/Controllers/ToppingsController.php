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
    public function index()
    {
        //la idea de esto es que el emprendedor pueda 
        //ver todos los toppings que tiene asi en general
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
        //falta probarlo
        //este siempre va a guardar el nuevo topping 
        //unido al producto, probablemente esto vaya en un for o algo asi XD

        $validData = $request->validate([
            'descripcion' => 'required|string|max:255',
            'precio' => 'required',
            'id_tienda' => 'required',
            'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            //esto puede ser diferente
            'id_producto' => 'required'
        ]);

        $p = Producto::find($validData['id_producto']);
        $t = Tienda::find($validData['id_tienda']);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        if(isset($p) && isset($t)){

            $topping = Toppings::create([
                'descripcion' => $validData['descripcion'],
                'precio' => $validData['precio'],
                'id_tienda' => $validData['id_tienda'],
                'imagen' => $validData['imagen'],
                'estado' => 1
            ]);

            if($validData['imagen'] != null){
                $request->file('imagen')->storeAs("public/images/toppings/{$t->id}/{$p->id}/{$topping->id}", $validData['imagen']);
            }

            $toppings_producto = ToppingsProductos::create([
                'id_producto' => $validData['id_producto'],
                'id_toppings' => $topping->id,
                'estado' => 1
            ]);


            return response()
            ->json([
                'message' => 'Categoría de tu tienda registrada',
                'topping' => $topping,
                'toppings_producto' => $toppings_producto  
            ], 200);



        } else {
            return response()
            ->json([
                'message' => 'El producto o la tienda no existen.',
                /* 'data' => '', */
            ], 400);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Toppings $toppings)
    {
        //
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
    public function update(Request $request, Toppings $toppings)
    {
        //a faltan cosas
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toppings $toppings)
    {
        //
    }
}
