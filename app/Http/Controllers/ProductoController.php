<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\PromocionProducto;
use App\Models\ResenaProducto;
use App\Models\Tienda;
use App\Models\Toppings;
use App\Models\ToppingsProductos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //no se toma en cuenta esta funcion
        $producto = Producto::where('estado',1) ->get();
        if (count($producto)==0) {
            return response()-> json('no existen categoria producto',404);
        }
        return response()->json($producto,200);

    }


    public function indexx()
    {
        $producto = DB::table('productos')
        ->join('tiendas','productos.id_tienda','=','tiendas.id')
        ->select('productos.*','tiendas.*')
        ->where('productos.estado',1)
        ->where('tiendas.estado',1)
    
        ->get();
        return response()->json($producto, 200);
    }


    public function getProductoTienda($id){
        $producto = Producto::where('id_tienda',$id)
        ->where('estado',1) 
        ->get();
        if (count($producto)==0) {
            return response()-> json('no existen Producto',404);
        }
        return response()->json($producto,200);
    }


    public function showCateProducto($id) {
        $tienda = DB::table('tiendas')->find($id);
    
        if (!$tienda) {
            return response()->json(['error' => 'Tienda no encontrada'], 404);
        }
        $data = Array();
        $categoria = DB::table('categorias_productos')
            ->select('categorias_productos.*')
            ->where('categorias_productos.estado', 1)
            ->where('categorias_productos.id_tienda', $id) 
            ->get(); 

            foreach ($categoria as $key => $value) {
                $productos = DB::table('productos')
                        ->select('productos.*')
                        ->where('id_categoria_productos', $value->id)
                        ->get();
             array_push($data, ['Categoria'=>$value, 'Productos'=>$productos]);
            }
        return response()->json($data, 200); 
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
        //probado con imagen y todo y funciona
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
            $request->file('imagen')->storeAs("public/images/productos/{$tienda_guardar->id}/{$producto->id}", $validData['imagen']);
        }
    if($producto->is_topping==1){
        $this->storeTopping($request,$producto->id,$producto->id_tienda);
    }
       
        return response()
        ->json([
            'message' => 'Producto de tu tienda registrado'
          /*   ,'data' => $producto    */
        ], 200);
    }

    
    public function storeTopping($request,$idProducto,$idTienda  )
    {
        $toppings=json_decode($request->toppings);
        $aux= count($toppings);
        for ($i=0; $i < $aux ; $i++) 
        { 
            $aux2=$toppings[$i];
             $p = Producto::find($idProducto);
            $t = Tienda::find($idTienda);

            if(isset($p) && isset($t))
            {
                $toppings_producto = ToppingsProductos::create([
                'id_producto' => $idProducto,
                'id_toppings' => $aux2,
                'estado' => 1
                ]);
            } 
            else 
            {
                 return response()
                        ->json([
                        'message' => 'El producto o la tienda no existen.',
                         ], 400);
            }
        }       
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dataProd=Array();
        $producto = Producto::find($id);
        $producto=DB::table('productos')
        ->join('categorias_productos','productos.id_categoria_productos','=','categorias_productos.id')
        ->join('tiendas','productos.id_tienda','=','tiendas.id')
        // ->join('toppings_productos','productos.id','=','toppings_productos.id_producto')
        // ->join('toppings','toppings_productos.id_toppings','=','toppings.id')
        ->select('productos.*','categorias_productos.descripcion as categoria')
        ->select('productos.*','categorias_productos.descripcion as categoria')
        ->select('productos.*',/* 'tiendas.*', */ 'tiendas.id_categoria_tienda as id_categoria_tienda')
        ->where('productos.estado',1)
        ->where('productos.id',$id)
        // ->where('toppings_productos.estado',1)
        ->get();
        if ($producto->isEmpty()) {
            return response()->json("El producto no existe",404);
        }
       $toppings=DB::table('toppings_productos')
       ->join('productos','toppings_productos.id_producto','=','productos.id')
       ->join('toppings','toppings_productos.id_toppings','=','toppings.id')
       ->select('toppings.*')
       ->where('toppings_productos.id_producto',$id)
       ->where('toppings_productos.estado',1)
       ->get();
       if ($toppings->isEmpty()) {
       $toppings="sin toppings";
        }
    array_push($dataProd,['Producto'=>$producto,'Toppings'=>$toppings]);
        return response()->json($dataProd,200);
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
    public function update(Request $request, $id_producto)
    {
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

        $producto_update = Producto::find($id_producto);

        $tienda_prod_updt = Tienda::find($producto_update->id_tienda);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        if($validData['imagen'] !=  $producto_update->imagen){  //revisar el funcionamiento de esto
            $producto_update->imagen = $validData['imagen'];

            $request->file('imagen')->storeAs("public/images/productos/{$tienda_prod_updt->id}/{$producto_update->id}", $validData['imagen']);
        }

        $producto_update->nombre = $validData['nombre'];
        $producto_update->precio = $validData['precio'];
        $producto_update->peso = $validData['peso'];
        $producto_update->id_categoria_productos = $validData['id_categoria_productos'];
        $producto_update->id_marca = $validData['id_marca'];
        $producto_update->id_tipo_peso = $validData['id_tipo_peso'];
        $producto_update->id_tienda = $validData['id_tienda'];
        $producto_update->descripcion = $validData['descripcion'];
        $producto_update->is_topping = $validData['is_topping'];

        $producto_update->save();

        return response()
        ->json([
            'message' => 'Producto de tu tienda actualizado',
            'data' => $producto_update   
        ], 200);        

    }
    public function Actualizar(Request $request, $id_producto){
        
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

        $producto_update = Producto::find($id_producto);

        $tienda_prod_updt = Tienda::find($producto_update->id_tienda);

        if (isset($validData['imagen'])) {
            $img = $request->file('imagen');
            $validData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validData['imagen'] = null;
        }

        if($validData['imagen'] !=  $producto_update->imagen){  //revisar el funcionamiento de esto
            $producto_update->imagen = $validData['imagen'];

            $request->file('imagen')->storeAs("public/images/productos/{$tienda_prod_updt->id}/{$producto_update->id}", $validData['imagen']);
        }

        $producto_update->nombre = $validData['nombre'];
        $producto_update->precio = $validData['precio'];
        $producto_update->peso = $validData['peso'];
        $producto_update->id_categoria_productos = $validData['id_categoria_productos'];
        $producto_update->id_marca = $validData['id_marca'];
        $producto_update->id_tipo_peso = $validData['id_tipo_peso'];
        $producto_update->id_tienda = $validData['id_tienda'];
        $producto_update->descripcion = $validData['descripcion'];
        $producto_update->is_topping = $validData['is_topping'];

        $producto_update->save();

        return response()
        ->json([
            'message' => 'Producto de tu tienda actualizado',
            'data' => $producto_update   
        ], 200);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_producto)
    {
        $producto_destroy = Producto::find($id_producto);

        $promo_prod_destroy = PromocionProducto::where('id_producto', $producto_destroy->id)->get();

        $rese_prod_destroy = ResenaProducto::where('id_producto', $producto_destroy->id)->get();

        $toppings_prod_destroy = ToppingsProductos::where('id_producto', $producto_destroy->id)->get();

        if($promo_prod_destroy == '[]' || $rese_prod_destroy == '[]' || $toppings_prod_destroy == '[]'){ //esto se me hace que es super ilegal pero funciona
            // aqui falta que haga cosas de verdad
            $producto_destroy->estado=0;
            $producto_destroy->save();
            return response()->json("El producto se elimino con exito", 200);
        }

        return response()->json(['message' => 'No se puede eliminar porque está ligada a un muchas cosas jaja']);

    }


    

    public function getProductoByTienda($id_tienda){
        //Busca todos los productos por la tienda

        $data = DB::table('productos')
        ->select('productos.*')
        ->where('productos.id_tienda', $id_tienda)
        ->where('productos.estado', 1)
        ->get();

        return response($data, 200);
        
    }

    public function getProductosByCategoria($idCategoria){
        $productos=DB::table('productos')
        //->join()
        ->select('productos.*')
        ->where('productos.id_categoria_productos',$idCategoria)
        ->where('productos.estado',1)
        ->get();
        return response()->json($productos);
    }
    
}
