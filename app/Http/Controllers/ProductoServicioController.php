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
            'descripcion'=>'required|max:255',
            'duracion'=>'required|max:255',
            'precio'=>'required',
            'puntuacion'=>'nullable',
            'imagen' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_categoria_productos'=>'required',
            'id_emp_servicio'=>'required',
        ]);
        $img = $request->file('imagen');
        $valiData['imagen'] =  time().'.'.$img->getClientOriginalExtension();

        $productoServicio=ProductoServicio::create([
            'nombre'=>$valiData['nombre'],
            'descripcion'=>$valiData['descripcion'],
            'duracion'=>$valiData['duracion'],
            'precio'=>$valiData['precio'],
            'puntuacion'=>$valiData['puntuacion'],
            'imagen'=>$valiData['imagen'],
            'id_categoria_productos'=>$valiData['id_categoria_productos'],
            'id_emp_servicio'=>$valiData['id_emp_servicio'],
            'estado'=>1,
        ]);

 
        $request->file('imagen')->storeAs("public/images/productoServicio/{$productoServicio->id}", $valiData['imagen']);
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
            'descripcion'=>'required|max:255',
            'duracion'=>'required|max:255',
            'precio'=>'required',
            'puntuacion'=>'nullable',
            'id_categoria_productos'=>'required',
            'id_emp_servicio'=>'required',
        ]);
        $productoServicio->nombre=$validateData['nombre'];
        $productoServicio->descripcion=$validateData['descripcion'];
        $productoServicio->duracion=$validateData['duracion'];
        $productoServicio->precio=$validateData['precio'];
        $productoServicio->puntuacion=$validateData['puntuacion'];
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


/*     public function UpdateImagenProductoServicio(Request $request, $id)
    {

        $productoServicio = ProductoServicio::find($id);
        if (is_null($productoServicio)) {
            return response()->json(['message' => 'Imagen no encontrada.'], 404);
        }
        $validData = $request->validate([
            'imagen' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $img=$request->file('imagen');
        $validData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('imagen')->storeAs("public/images/productoServicio/{$productoServicio->id}", $validData['imagen']);
        $productoServicio->imagen = $validData['imagen'];
        $productoServicio->save();
        return response()->json(['message' => 'Imagen actualizada........'], 201);
    } */
    

    public function editImagenes(Request $request, $id ){

        $productoServicio = ProductoServicio::find($id);
        if (is_null($productoServicio)) {
            return response()->json(['message' => 'productoServicio no encontrada.'], 404);
        }
        $validateData = $request->validate([
            'imagen' => 'required|mimes:jpeg,bmp,png',
        ]);
        $img=$request->file('imagen');
        $validateData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        $request->file('imagen')->storeAs("public/images/productoServicio/{$productoServicio->id}", $validateData['imagen']);
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

}
