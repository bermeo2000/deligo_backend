<?php

namespace App\Http\Controllers;

use App\Models\ProductoServicio;
use Illuminate\Http\Request;
use App\Models\Tienda;
use Illuminate\Support\Facades\DB;

class ProductoServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $productoServicio = ProductoServicio::where('estado',1) ->get();
        if (count($productoServicio)==0) {
            return response()-> json('no existen producto Servicio',404);
        }
        return response()->json($productoServicio,200);
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
        $valiData=$request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|max:255',
            'duracion'=>'required|max:255',
            'precio'=>'required',
            /* 'puntuacion'=>'nullable', */
            'imagen' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_categoria_productos'=>'required',
            'id_emp_servicio'=>'required',
        ]);

        $valiData['imagen'] =  $request->file('imagen')->storePublicly("public/images/productoServicio");

        $productoServicio=ProductoServicio::create([
            'nombre'=>$valiData['nombre'],
            'descripcion'=>$valiData['descripcion'],
            'duracion'=>$valiData['duracion'],
            'precio'=>$valiData['precio'],
           /*  'puntuacion'=>$valiData['puntuacion'], */
            'imagen'=>$valiData['imagen'],
            'id_categoria_productos'=>$valiData['id_categoria_productos'],
            'id_emp_servicio'=>$valiData['id_emp_servicio'],
            'estado'=>1,
        ]);

        return response()->json(['message'=>'producto Servicio registrado'],200);
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $productoServicio= ProductoServicio::find($id);
        if (is_null($productoServicio)) {
            return response()->json(['message'=> "producto Servicio no encontrado"],404);
        }
        return response()->json($productoServicio,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductoServicio $productoServicio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_producto_servicio)
    {
        $productoServicio= ProductoServicio::find($id_producto_servicio);
        if (is_null($id_producto_servicio)) {
           return response()->json(['message'=> 'productoServicio no encontrado'], 404);
        }
        $validateData=$request->validate([
            'nombre'=>'required|string|max:255',
            'descripcion'=>'nullable|max:255',
            'duracion'=>'required|max:255',
            'precio'=>'required',
            /* 'puntuacion'=>'nullable', */
            'id_categoria_productos'=>'required',
            'id_emp_servicio'=>'required',
        ]);
        $productoServicio->nombre=$validateData['nombre'];
        $productoServicio->descripcion=$validateData['descripcion'];
        $productoServicio->duracion=$validateData['duracion'];
        $productoServicio->precio=$validateData['precio'];
       /*  $productoServicio->puntuacion=$validateData['puntuacion']; */
        $productoServicio->id_categoria_productos=$validateData['id_categoria_productos'];
        $productoServicio->id_emp_servicio=$validateData['id_emp_servicio'];
        $productoServicio->save();
        return response()->json(['message'=>"Producto Servicio actualizado"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $productoServicio= ProductoServicio::find($id);
        if (is_null($productoServicio)) {
           return response()->json(['message'=> 'Producto Servicio no encontrado'], 404);
        }
        $productoServicio->estado=0;
        $productoServicio->save();
        return response()->json(['message' => 'El roducto Servicio Eliminado'], 201);

    }

    public function editImagenes(Request $request, $id ){

        $productoServicio = ProductoServicio::find($id);
        if (is_null($productoServicio)) {
            return response()->json(['message' => 'productoServicio no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'imagen' => 'required|mimes:jpeg,bmp,png',
        ]);

        $validateData['imagen'] = $request->file('imagen')->storePublicly("public/images/productoServicio");

        $productoServicio->imagen=$validateData['imagen'];
        $productoServicio->save();
        return response()->json(['message' => 'Imagen de productoServicio actualizada'], 201);
    }


    public function getProductoServicio($id){
        $productoServicio = ProductoServicio::where('id_emp_servicio',$id)
        ->where('estado',1) 
        ->get();
        if (count($productoServicio)==0) {
            return response()-> json('no existen producto Servicio',404);
        }
        return response()->json($productoServicio,200);
    }

    public function getProductoByTiendaAndFecha($idTienda, $fecha){
        $productoServicio = DB::Table('detalle_ventas')
        ->join('producto_servicios','detalle_ventas.id_producto_servicio','=','producto_servicios.id')
        ->join('tiendas','producto_servicios.id_emp_servicio','=','tiendas.id')
        ->select('detalle_ventas.fecha_cita as dia', 'detalle_ventas.hora_cita as horaInicio',
        'producto_servicios.duracion','producto_servicios.nombre as nombreServicio', 'producto_servicios.precio','producto_servicios.imagen',
        'tiendas.nombre_tienda')
        ->where('detalle_ventas.id_tienda',$idTienda)
        ->when($fecha !== 'null', function ($query) use ($fecha) {
            return $query->where('detalle_ventas.fecha_cita', $fecha);
        })
        ->where('detalle_ventas.estado',1) 
        ->orderBy('horaInicio', 'asc')
        ->get();
        if (count($productoServicio)==0) {
            return response()-> json('no existen Citas en el dia',404);
        }
        return response()->json($productoServicio,200);
    }
    public function getProductoByUsuario($idUsuario,$fecha){
        $productoServicio = DB::Table('detalle_ventas')
        ->join('producto_servicios','detalle_ventas.id_producto_servicio','=','producto_servicios.id')
        ->join('ventas','detalle_ventas.id_venta','=','ventas.id')
        ->join('tiendas','producto_servicios.id_emp_servicio','=','tiendas.id')
        ->select('detalle_ventas.fecha_cita as dia', 'detalle_ventas.hora_cita as horaInicio',
        'producto_servicios.duracion','producto_servicios.nombre as nombreServicio', 'producto_servicios.precio','producto_servicios.imagen',
        'tiendas.nombre_tienda')
        ->when($fecha !== 'null', function ($query) use ($fecha) {
            return $query->where('detalle_ventas.fecha_cita', $fecha);
        })
        ->where('detalle_ventas.estado',1) 
        ->where('ventas.id_cliente',$idUsuario)
        ->orderBy('horaInicio', 'asc')
        ->get();
        if (count($productoServicio)==0) {
            return response()-> json('no existen Citas en el dia',404);
        }
        return response()->json($productoServicio,200);
    }

    public function getServicioCategoria($idCategoria){
        $productoServicio = ProductoServicio::where('estado',1) 
        ->where('id_categoria_productos',$idCategoria)
        ->get();
        if (count($productoServicio)==0) {
            return response()-> json('no existen producto Servicio',404);
        }
        return response()->json($productoServicio,200);
    }

}
