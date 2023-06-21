<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\CategoriaTienda;
use App\Models\Producto;
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
        //probado sin imagen
        $validData = $request->validate([
            'descripcion' => 'required|string|max:255',
            'imagen' => 'nullable',
            'id_tienda' => 'required',
        ]);

        $tienda_guardar = Tienda::find($validData['id_tienda']);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        $cat_prod_store = CategoriasProductos::create([
            'descripcion' => $validData['descripcion'],
            'imagen' => $validData['imagen'],
            'id_tienda' => $validData['id_tienda'],
            'estado' => 1
        ]);

        if($validData['imagen'] != null){
            $request->file('imagen')->storeAs("public/images/categorias_tienda/{$tienda_guardar->id}/{$cat_prod_store->id}", $validData['imagen']);
        }

        return response()
        ->json([
            'message' => 'Categoría de tu tienda registrada',
            'data' => $cat_prod_store   
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // no se está usando
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
    public function update(Request $request, $id_categoria_producto)
    {
        //No está probado
        $validData = $request->validate([
            'descripcion' => 'required|string|max:255',
            'id_tienda' => 'required',
        ]);

        $cat_prod_update = CategoriasProductos::find($id_categoria_producto);

        $cat_prod_update->descripcion = $validData['descripcion'];
        $cat_prod_update->id_tienda = $validData['id_tienda'];

        return response()
        ->json([
            'message' => 'Categoría de tu tienda actualizada.',
            'data' => $cat_prod_update   
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_categoria_producto)
    {
        //no está probado
        $cat_prod_destroy = CategoriasProductos::find($id_categoria_producto);

        $productos = Producto::where('id_categoria_productos', $cat_prod_destroy->id)
        ->get();

        if($productos == '[]'){ //esto se me hace que es super ilegal pero funciona
            //aqui falta que haga cosas de verdad
            return response()->json(['message' => 'Está vació y debería borrar', 'data' => $productos]);
        }

        return response()->json(['message' => 'No se puede eliminar porque está ligado a un producto', 'data' => $productos]);


    }

    public function getCatProducByTienda($id_tienda){
        /* 
            Con este buscamos las categorias de 
            tiendas por el ID de la tienda
        */
        $data = DB::table('categorias_productos')
        ->where('id_tienda', $id_tienda)
        ->where('estado', 1)
        ->get();

        return response($data, 200);
        //probado
    }

    
    
}
