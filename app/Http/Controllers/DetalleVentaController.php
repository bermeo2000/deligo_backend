<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\PromocionProducto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DetalleVentaController extends Controller
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
    }

    /**
     * Display the specified resource.
     */
    public function show(DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetalleVenta $detalleVenta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetalleVenta $detalleVenta)
    {
        //
    }


    public function showDetallesByVentas($idVenta)
    {
        $detalleVenta=Array();
        $detalleProducto=null;
        $detallePromocion=null;
        // $detalles=DB::table('detalle_ventas')
        // ->leftJoin('productos','detalle_ventas.id_producto','=','productos.id')
        // ->leftJoin('promocion_productos','detalle_ventas.id_promocion_productos','=','promocion_productos.id')
        // ->select()
        // ->get();
        $detalles=DetalleVenta::where('id_venta',$idVenta)
        ->where('estado',1)
        ->get();
        if ($detalles->isEmpty()) 
        {
            return response()->json("No se encontraron detalles de esta venta",404);
        }
        foreach ($detalles as $key => $det) 
        {
            if ($det->id_producto!=null) 
            {
                $detalleProducto=DB::table('detalle_ventas')
                 ->join('productos','detalle_ventas.id_producto','=','productos.id')
                 ->join('categorias_productos','productos.id_categoria_productos','=','categorias_productos.id')
                 ->leftJoin('tipo_pesos','productos.id_tipo_peso','=','tipo_pesos.id')
                 ->leftJoin('marcas','productos.id_marca','=','marcas.id')
                 ->join('tiendas','productos.id_tienda','=','tiendas.id')
                 //->leftJoin('promocion_productos','detalle_ventas.id_promocion_productos','=','promocion_productos.id')
                 ->select('detalle_ventas.*', 
                 'productos.nombre as nombreProd','productos.precio as precioProd','productos.descripcion as descripcionProd','productos.imagen as imagenProd',
                 'categorias_productos.descripcion as categoria', 
                 'tipo_pesos.descripcion as tipoPeso',
                 'marcas.descripcion as marca',
                 'tiendas.nombre_tienda as tienda')
                 ->where('detalle_ventas.id_producto',$det->id_producto)
                 ->where('detalle_ventas.id_venta',$det->id_venta)
                 ->get();
    
            }
            else 
            {
                 $detallePromocion=DB::table('detalle_ventas')
                 ->join('promocion_productos','detalle_ventas.id_promocion_producto','=','promocion_productos.id')
                 ->join('productos','promocion_productos.id_producto','=','productos.id')
                 ->join('categorias_productos','productos.id_categoria_productos','=','categorias_productos.id')
                 ->leftJoin('tipo_pesos','productos.id_tipo_peso','=','tipo_pesos.id')
                 ->leftJoin('marcas','productos.id_marca','=','marcas.id')
                 ->join('tiendas','productos.id_tienda','=','tiendas.id')
                 //->leftJoin('promocion_productos','detalle_ventas.id_promocion_productos','=','promocion_productos.id')
                 ->select('detalle_ventas.*', 
                 'productos.nombre as nombreProd','productos.precio as precioProd','productos.descripcion as descripcionProd','productos.imagen as imagenProd',
                 'categorias_productos.descripcion as categoria', 
                 'tipo_pesos.descripcion as tipoPeso',
                 'marcas.descripcion as marca',
                 'tiendas.nombre_tienda as tienda')
                 ->where('detalle_ventas.id_producto',$det->id_producto)
                 ->where('detalle_ventas.id_venta',$det->id_venta)
                 ->get();
                $detalle=PromocionProducto::find($det->id_promocion_producto);
            }

            if($det->array_toppings_selec!="null")
            {
                
            }

            array_push($detalleVenta,['Producto'=>$detalleProducto,'productoPromocion'=>$detallePromocion]);
        }
        return response()->json($detalleVenta);
    }

}
