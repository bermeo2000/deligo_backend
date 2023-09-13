<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\User;
use App\Models\DetalleVenta;
use App\Models\Tienda;
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
        //return response()->json($tiendas);
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
        if (count($aux->array_toppings_selec) ==0) {
            $aux->array_toppings_selec=NULL;
        }
        $detalle=DetalleVenta::create([
            'anotes'=>$aux->anote,
            'id_producto'=>$aux->idProducto,
            'id_tienda'=>$aux->id_tienda,
            'precio'=>$aux->precioProducto,
            'cantidad'=>$aux->cantidad_compra,
            'id_promocion_producto'=>$aux->id_promocion_producto,
            'array_toppings_selec'=>json_encode($aux->array_toppings_selec),
            'id_venta'=>$idVenta,
            'estado'=>1
        ]);
       
       } 
      

    }

    public function restarVentas($id_tienda)
    {
        
            $tienda=Tienda::find($id_tienda);
            $user=User::find($tienda->id_propietario);
            if($user->is_plus==0)
            {
                $ventas=$tienda->ventas;
                $tienda->ventas=$ventas-1;
                $tienda->save();
            }
           
    }


}
