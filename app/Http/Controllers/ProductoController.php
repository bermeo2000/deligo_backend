<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
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
        $validData = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required',
            'peso' => 'nullable',
            'imagen' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_categoria_productos' => 'required',
            'id_marca' => 'nullable',
            'id_tipo_peso' => 'nullable',
            'id_tienda' => 'required',
            'descripcion' => 'nullable',
            'is_topping' => 'required',
        ]);

        $tienda_guardar = Tienda::find($validData['id_tienda']);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        $producto = Producto::create([
            'nombre' => $validData['nombre'],
            'precio' => $validData['precio'],
            'peso' => $validData['peso'],
            'imagen' => $validData['imagen'],
            'estado' => 1,
            'id_categoria_productos' => $validData['id_categoria_productos'],
            'id_marca' => $validData['id_marca'],
            'id_tipo_peso' => $validData['id_tipo_peso'],
            'id_tienda' => $validData['id_tienda'],
            'descripcion' => $validData['descripcion'],
            'is_topping' => $validData['is_topping'],
        ]);

        if($validData['imagen'] != null){
            $request->file('imagen')->storeAs("public/images/categorias_tienda/{$tienda_guardar->id}/{$producto->id}", $validData['imagen']);
        }
        
        return response()
        ->json([
            'message' => 'Producto de tu tienda registrado',
            'data' => $producto   
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }

    public function getProductoByTienda($id_tienda){
        //Busca todos los productos por la tienda

        $data = DB::table('productos')
        ->where('id_tienda', $id_tienda)
        ->where('estado', 1)
        ->get();

        return response($data, 200);
        
    }

}
