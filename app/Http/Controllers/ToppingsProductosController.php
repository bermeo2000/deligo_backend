<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Toppings;
use App\Models\ToppingsProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToppingsProductosController extends Controller
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
        //este metodo va a guardar unicamente la union
        //del topping con el producto

        $validData = $request->validate([
            'id_producto' => 'required',
            'id_toppings' => 'required'
        ]);

        $p = Producto::find($validData['id_producto']);
        $t = Toppings::find($validData['id_toppings']);

        if(isset($p) && isset($t)){
            $toppings_producto = ToppingsProductos::create([
                'id_producto' => $validData['id_producto'],
                'id_toppings' => $validData['id_toppings'],
                'estado' => 1
            ]);

            return response()
            ->json([
                'message' => 'Topping asignado al producto',
                'data' => $toppings_producto   
            ], 200);

        } else {

            return response()
            ->json([
                'message' => 'El producto o el topping no existen.',
                /* 'data' => '', */
            ], 400);

        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id_producto)
    {
        //devuelve todos los toppings de un producto
        //no está probado

        $data = DB::table('toppings_productos')
        ->join('toppings', 'toppings_productos.id_toppings', '=', 'toppings.id')
        ->select('toppings.*')
        ->where('toppings_productos.id_producto', $id_producto)
        ->where('toppings_productos.estado', 1)
        ->where('toppings.estado', 1)
        ->get();

        return response()->json($data, 200); 

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToppingsProductos $toppingsProductos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_toppings_productos)
    {
        //no esta probado

        $toppings_productos_upd = ToppingsProductos::find($id_toppings_productos);

        $validData = $request->validate([
            'id_producto' => 'required',
            'id_toppings' => 'required'
        ]);

        $p_udp = Producto::find($validData['id_producto']);
        $t_udp = Toppings::find($validData['id_toppings']);

        //esta validacion se puede pasar a una funcion sola (?)

        if(isset($p_udp) && isset($t_udp)){
            
            $toppings_productos_upd->id_producto = $validData['id_producto'];
            $toppings_productos_upd->id_toppings = $validData['id_toppings'];

            $toppings_productos_upd->save();

            return response()
            ->json([
                'message' => 'Topping - Producto actualizado',
                'data' => $toppings_productos_upd   
            ], 200);

        } else {
            return response()
            ->json([
                'message' => 'El producto o el topping no existen.',
                /* 'data' => '', */
            ], 400);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_toppings_productos)
    {
        //no esta probado y puede que esté mal
        $toppings_productos_des = ToppingsProductos::find($id_toppings_productos);
        
        if (isset($toppings_productos_des)) {
            $toppings_productos_des->estado = 0;
            $toppings_productos_des->save();

            return response()
            ->json([
                'message' => 'Topping - Producto eliminado (?)',
                'data' => $toppings_productos_des   
            ], 200);

        } else {
            return response()
            ->json([
                'message' => 'Topping - Producto no existen',
                /* 'data' => '', */
            ], 400);
        }
        

        
    }
}
