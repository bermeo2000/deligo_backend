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
    public function index()
    {
        // * Retorna todas las categorías sin diferenciar tienda
        $categorias_productos = CategoriasProductos::where('estado',1) ->get();
        if (count($categorias_productos)==0) {
            return response()-> json('no existen categoria producto',404);
        }
        return response()->json($categorias_productos,200);

    }

    public function create()
    {
        
    }

    // * Guarda categorías que vienen en array 
    public function store(Request $request)
    {
        // TODO Revisar esto con el nuevo frontend
        $idTienda=$request->id_tienda;
        $categoria_productos=json_decode($request->categoria_productos,true);
        $aux= count($categoria_productos);
        for ($i=0; $i < $aux ; $i++) 
        { 
            $aux2=$categoria_productos[$i];
            $categoriaproductos=CategoriasProductos::create([
                'descripcion' => $aux2['descripcion'],
                'id_tienda' => $idTienda,
                'estado' => 1
            ]);
        }       

        return response()->json(['message'=>'Categoría registrada'], 200);
    }

    // * Busca una categoría en especifico
    public function show($id)
    {
        $categoria_productos=CategoriasProductos::find($id);
        if (is_null($categoria_productos)) {
            return response()->json(['message' => 'categoria_productos no encontrado'], 404);
        }
        return response()->json($categoria_productos);
    }

    // * Filtra las categorias por tienda
    public function getCategoriaProductoByTienda($id_tienda){
        $categoria_productos = CategoriasProductos::where('id_tienda',$id_tienda)
        ->where('estado',1) 
        ->get();
        if (count($categoria_productos) == 0) {
            return response()->json(
                [
                    'message' => 'No existen categorías en esta tienda.'
                ],
                404
            );
        }
        return response()->json($categoria_productos,200);
    }







    // TODO Revisar todo de aquí para abajo
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
        $categoria_productos = CategoriasProductos::find($id);
        if (is_null($id)) {
            return response()->json(['message' => 'categorias_productos no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'descripcion'=>'required|string|max:255',
            'id_tienda' =>'required',
            
        ]);
        $categoria_productos->descripcion = $validateData['descripcion'];
        $categoria_productos->id_tienda = $validateData['id_tienda'];
        $categoria_productos->save();
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
         $categoria_productos=CategoriasProductos::find($id);
         if (is_null($categoria_productos)) {
             return response()->json(['message' => 'categorias_productos no encontrada'], 404);
         }
         $categoria_productos->estado = 0;
         $categoria_productos->save();
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

        return response()->json("La categoria se elimino con exito", 200);
    }

    

    
    
}
