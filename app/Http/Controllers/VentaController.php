<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\User;
use App\Models\DetalleVenta;
use App\Models\Tienda;
use App\Models\DetalleVentaTopping;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        return response()->json($cod);
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
        $aux=json_decode($request->detalles);
        $tiendas= collect($aux)->pluck('id_tienda')->unique()->toArray();
        //return response()->json($aux);
        $ValidateData = $request->validate([
            'total'                    => 'required',
            'fecha'                    => 'required',
            'id_cliente'               => 'required|string|max:255',
            'id_tipo_pago'             => 'required|string|max:255',
            'imagen_transferencia'     => '',
            //'id_tipo_usuario'   => 'required',
            //'is_categoria_selec'=>'required',
        ]);
        $cod=$this->generarCodigoVenta();
        $ventas = Venta::create(
            [
            ...$ValidateData,
            'codigo_comprobante'=>$cod,
            'estado'=>1
            ]);
          
            $this->storeDetalleVenta($ventas->id, $aux);
            $numTienda=count($tiendas);
            for ($i=0; $i <$numTienda ; $i++) { 
                $this->restarVentas($tiendas[$i]);
            }
           
        return response()->json(['message' => 'Compra existosa'], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Venta $venta)
    {
        //
    }
       
    public function generarCodigoVenta(){
        $longitud=8;
        $aux =Str::random($longitud);
        $cod="DG-".$aux;
        return  $cod;
         
    }

    public function storeDetalleVenta($idVenta,$detalles){

       for ($i=0; $i < count($detalles); $i++) 
       { 
        $aux=$detalles[$i];
        if ($aux->id_promocion_producto=="null") {
            $aux->id_promocion_producto=NULL;
        }
        if ($aux->idProducto =="null") {
            $aux->idProducto=NULL;
        }
        $detalle=DetalleVenta::create([
            'anotes'=>$aux->anote,
            'id_producto'=>$aux->idProducto,
            'id_tienda'=>$aux->id_tienda,
            'precio'=>$aux->precioProducto,
            'cantidad'=>$aux->cantidad_compra,
            'id_promocion_producto'=>$aux->id_promocion_producto,
            //'array_toppings_selec'=>json_encode($aux->array_toppings_selec),
            'id_venta'=>$idVenta,
            'estado'=>1
        ]);
       if ( count($aux->toppings)>0) 
       {
        for ($i=0; $i <count($aux->toppings) ; $i++) { 
            $auxTopping=$aux->toppings[$i];
            $detalleTopping=DetalleVentaTopping::create([
                'id_detalle_venta'=>$detalle->id,
                'id_topping'  => $auxTopping->id,
                'cantidad'        =>$auxTopping->cantidad,
                'total_toppings'=>$auxTopping->precio,
                'estado'=>1
            ]);
        }
        
       }
       } 
      

    }

    public function restarVentas($id_tienda)
    {
        
            $tienda=Tienda::find($id_tienda);
            $user=User::find($tienda->id_propietario);
            if($user->is_plus==0)
            {
                $ventas=$user->ventas;
                $user->ventas=$ventas-1;
                $user->save();
            }
           
    }

    public function getVentasByUsuario($id){
            $ventas= DB::table('ventas')
            ->join('tipo_pagos','ventas.id_tipo_pago','=','tipo_pagos.id')
            ->select('ventas.*', 'tipo_pagos.descripcion as metodoPago')
            ->where('ventas.estado',1)
            ->where('ventas.id_cliente',$id)
            ->get();
            if ($ventas->isEmpty()) {
               return response()->json("No ha realizado ningun pedido hast ahora",404);
            }
            return response()->json($ventas,200);
    }


}
