<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\PromocionProducto;
use App\Models\ResenaProducto;
use App\Models\Tienda;
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
        $producto = Producto::where('estado',1)->get();
        return response()->json($producto, 200);

        //esto no se usa
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
    public function update(Request $request, $id_producto)
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
        //NO ESTA PROBADO
        //promocion producto, reseña producto y  
        //toppings productos se deben tambien eliminar 
        //detalle de ventas no, porque queremos mantener el 
        //historico de la venta de ese producto

        $producto_destroy = Producto::find($id_producto);

        $promo_prod_destroy = PromocionProducto::where('id_producto', $producto_destroy->id)->get();

        $rese_prod_destroy = ResenaProducto::where('id_producto', $producto_destroy->id)->get();

        $toppings_prod_destroy = ToppingsProductos::where('id_producto', $producto_destroy->id)->get();

        if($promo_prod_destroy == '[]' || $rese_prod_destroy == '[]' || $toppings_prod_destroy == '[]'){ //esto se me hace que es super ilegal pero funciona
            //aqui falta que haga cosas de verdad
            return response()->json([
                'message' => 'Está vació y debería borrar', 
                'promo_prod_destroy' => $promo_prod_destroy,
                'rese_prod_destroy' => $rese_prod_destroy,
                'toppings_prod_destroy' => $toppings_prod_destroy
            ]);
        }

        return response()->json(['message' => 'No se puede eliminar porque está ligada a un muchas cosas jaja']);

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
