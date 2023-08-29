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
        $categorias_productos = CategoriasProductos::where('estado',1) ->get();
        if (count($categorias_productos)==0) {
            return response()-> json('no existen categoria producto',404);
        }
        return response()->json($categorias_productos,200);

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
            'id_tienda' => 'required',
        ]);


        $cat_prod_store = CategoriasProductos::create([
            'descripcion' => $validData['descripcion'],
            'id_tienda' => $validData['id_tienda'],
            'estado' => 1
        ]);

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
    public function update(Request $request, $id)
    {
        $categorias_productos = CategoriasProductos::find($id);
        if (is_null($categorias_productos)) {
            return response()->json(['message' => 'categorias_productos no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'descripcion'=>'required|string|max:255',
            'id_tienda' =>'required',
            
        ]);
        $categorias_productos->descripcion = $validateData['descripcion'];
        $categorias_productos->id_tienda = $validateData['id_tienda'];
        $categorias_productos->save();
        return response()->json(['message' => 'categorias_productos actualizado'], 200);
    }

    public function updates(Request $request, $id_categoria_producto)
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

     public function destroy($id)
     {
         $categorias_productos=CategoriasProductos::find($id);
         if (is_null($categorias_productos)) {
             return response()->json(['message' => 'categorias_productos no encontrada'], 404);
         }
         $categorias_productos->estado = 0;
         $categorias_productos->save();
         return response()->json(['message'=>'categorias_productos eliminada']);
     }
     
    public function destroys($id_categoria_producto)
    {
        //no está probado
        $cat_prod_destroy = CategoriasProductos::find($id_categoria_producto);

        $productos = Producto::where('id_categoria_productos', $cat_prod_destroy->id)
        ->get();

      /*   if($productos == '[]'){ 
            return response()->json(['message' => 'Está vació y debería borrar', 'data' => $productos]);
        } */

        return response()->json(['message' => 'se ha eliminado el producto' ]);
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
