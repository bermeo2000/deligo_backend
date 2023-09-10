<?php

namespace App\Http\Controllers;

use App\Models\Venta;
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

    public function restarVentas(){
        $longitud=8;
        $aux =Str::random($longitud);
        $cod="DG-".$aux;
        return  $cod;
        
    }
}
