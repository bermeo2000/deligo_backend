<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\CategoriaTienda;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Esto es para admin creo XDD
        $categorias_productos = CategoriasProductos::where('estado', 1)->get();

        return response()->json($categorias_productos, 200);

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
            'descripcion' => 'required|string|max:255',
            'imagen' => 'null',
            'id_tienda' => 'required',
        ]);

        $tienda_guardar = Tienda::find($validData['id_tienda']);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        $cat_tienda = CategoriaTienda::create([
            'descripcion' => $validData['descripcion'],
            'imagen' => $validData['imagen'],
            'id_tienda' => $validData['id_tienda'],
            'estado' => 1
        ]);

        $request->file('imagen')->storeAs("public/images/categorias_tienda/{$tienda_guardar->id}/{$cat_tienda->id}", $validData['imagen']);

        return response()
        ->json([
            'message' => 'Categoría de tu tienda registrada',
            'data' => $cat_tienda   
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(CategoriasProductos $categoriasProductos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriasProductos $categoriasProductos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriasProductos $categoriasProductos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriasProductos $categoriasProductos)
    {
        //
    }

    /* 
    Con este buscamos las categorias de tiendas por el ID de la tienda
    */
    public function categoriasPorTienda($id_tienda){
        $data = DB::table('categorias_productos')
        ->where('id_tienda', $id_tienda)
        ->where('estado', 1)
        ->get();

        return response($data, 200);
    }
}
