<?php

namespace App\Http\Controllers;

use App\Models\Tienda;
use App\Models\User;
use App\Models\CategoriasUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$tienda = Tienda::where('estado',1)->get();
        // ya no se usa
      /*   $tienda=DB::table('tiendas')
        ->join('categoria_tiendas','tiendas.id_categoria_tienda','=','categoria_tiendas.id')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('tiendas.estado',1)
        ->get();
        return response()->json($tienda, 200); */
        $tienda = Tienda::where('estado',1) ->get();
        if (count($tienda)==0) {
            return response()-> json('no existen tienda',404);
        }
        return response()->json($tienda,200);
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
        
    }

    public function update(Request $request, $id_tienda)
    {
        $tienda = Tienda::find($id_tienda);
        if (is_null($id_tienda)) {
            return response()->json(['message' => 'tienda no encontrado.'], 404);
        }
        $validateData = $request->validate([
            'nombre_tienda'            => 'required|string|max:255',
            'ciudad'                    => 'required|string|max:255',
            'direccion'                => 'nullable|string|max:255',
            'celular'                  => 'required|string|max:255',
            'descripcion'              => 'nullable',
            /* 'lat'                      =>'nullable',
            'lng'                      =>'nullable', */
            
        ]);
        $tienda-> nombre_tienda = $validateData['nombre_tienda'];
        $tienda-> ciudad        = $validateData['ciudad'];
        $tienda-> direccion     = $validateData['direccion'];
        $tienda-> celular       = $validateData['celular'];
        $tienda-> descripcion   = $validateData['descripcion'];
   /*      $tienda-> lat           = $validateData['lat'];
        $tienda-> lng           = $validateData['lng']; */
        $tienda->save();
        return response()->json(['message' => 'tienda actualizado'], 200);
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tienda $tienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message' => 'tienda no encontrada'], 404);
        }
        $tienda->estado = 0;
        $tienda->save();
       /*  return response()->json(['message'=>'Marca eliminada']); */
       return response()->json("La tienda se elimino con exito", 200);
    }



    public function storeEmprendedor(Request $request){
        //return response()->json($request);
        $validateData=$request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'email'             => 'required|string|max:255',
            'password'           => 'required|string|max:255',
            'ciudad'            => 'required|string|max:255',
            'cedula'            => 'required|string|max:255',
            'telefono'          => 'required|string|max:255',
            'imagen'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'id_codigo_pais'    => 'required',
            'id_tipo_usuario'   => 'required',
            'is_categoria_selec'=> 'required',

        ]);
        if (isset($validateData['imagen'])) {
           // return response()->json('entro');
            $img = $request->file('imagen');
            $validateData['imagen'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validateData['imagen'] = null;
        }

        $codigo=$this->generarCodigo($validateData['nombre']);
        while (User::where('codigo_referido',$codigo)->exists()) {
            $codigo=$this->generarCodigo();
        }
        $usuario=User::create([
            'nombre'            =>$validateData['nombre'],
            'apellido'          =>$validateData['apellido'],
            'email'             =>$validateData['email'],
            'password'          =>$validateData['password'],
            'ciudad'            =>$validateData['ciudad'],
            'cedula'            =>$validateData['cedula'],
            'telefono'          =>$validateData['telefono'],
            'imagen'            =>$validateData['imagen'],
            'id_codigo_pais'    =>$validateData['id_codigo_pais'],
            'id_tipo_usuario'   =>$validateData['id_tipo_usuario'],
            'is_categoria_selec'=>$validateData['is_categoria_selec'],
            'codigo_referido'   =>$codigo,
            'codigo_referido_usuario'=>$codigo,
            'ventas'                =>100,
            'estado'            =>1,
        ]);
        if(isset($usuario->imagen)){
            $img->storeAs("public/images/usuario/{$usuario->id}", $validateData['imagen']);
        }
        


        if ($validateData['is_categoria_selec']==1) {
            $array = explode(",",$request->categorias);
            for ($i = 0; $i < count($array); $i++) {
                $aux=$array[$i];
                CategoriasUsuario::create([
                    'estado' => 1,
                    'id_usuario' => $usuario->id,
                    'id_categoria_tienda' => $aux,
                ]);
            }
        } 
        

       $this->storeTienda($request,$usuario);
        return response()->json("funciono");

        

    }

    public function generarCodigo( $nombre)
    {
       
        $primerosDigitosNombre=substr($nombre,0,3);
        $numAleatorios=str_pad(mt_rand(0,9999),4,'0',STR_PAD_LEFT);
        $codigo="DG-" . $primerosDigitosNombre . $numAleatorios;
        return $codigo;
         
    }

    public function storeTienda($request, $usuario){
        $validateDataTienda=$request->validate([
            'nombre_tienda'            => 'required|string|max:255',
            'id_categoria_tienda'      => 'required',
            'ciudadTienda'             => 'required|string|max:255',
            'direccion'                => 'nullable|string|max:255',
            'celular'                  => 'required|string|max:255',
            'id_codigo_pais'           => 'required',
            'instagram_user'           => 'nullable|string|max:255',
            'facebook_user'            => 'nullable|string|max:255',
            'tiktok_user'              => 'nullable|string|max:255',
            'lat'                      => 'nullable',
            'lng'                      => 'nullable',
            'is_delivery'              => 'required',
            'cargo_delivery'           => 'nullable',
            'tiempo_delivery_min'      => 'nullable',
            'puntuacion'               => 'required',
            'descripcion'              => 'nullable',
            'imagen_tienda'            => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'hora_apertura'            => 'required',
            'hora_cierre'              => 'required',
            'llegada_previa'           => 'nullable',

        ]);
        if (isset($validateDataTienda['imagen_tienda'])) {
            $img = $request->file('imagen_tienda');
            $validateDataTienda['imagen_tienda'] = time() . '.' . $img->getClientOriginalExtension();
        } else {
            $validateDataTienda['imagen_tienda'] = null;
        }
        
        $tienda=Tienda::create([
            'nombre_tienda'            =>$validateDataTienda['nombre_tienda'],
            'id_propietario'           =>$usuario->id,
            'id_categoria_tienda'      =>$validateDataTienda['id_categoria_tienda'],
            'ciudad'                   =>$validateDataTienda['ciudadTienda'],
            'direccion'                =>$validateDataTienda['direccion'],
            'celular'                  =>$validateDataTienda['celular'],
            'id_codigo_pais'           =>$validateDataTienda['id_codigo_pais'],
            'instagram_user'           =>$validateDataTienda['instagram_user'],
            'facebook_user'            =>$validateDataTienda['facebook_user'],
            'tiktok_user'              =>$validateDataTienda['tiktok_user'],
            'lat'                      =>$validateDataTienda['lat'],
            'lng'                      =>$validateDataTienda['lng'],
            'is_delivery'              =>$validateDataTienda['is_delivery'],
            'cargo_delivery'           =>$validateDataTienda['cargo_delivery'],
            'tiempo_delivery_min'      =>$validateDataTienda['tiempo_delivery_min'],
            'puntuacion'               =>$validateDataTienda['puntuacion'],
            'descripcion'              =>$validateDataTienda['descripcion'],
            'imagen'                   =>$validateDataTienda['imagen_tienda'],
            'hora_apertura'            =>$validateDataTienda['hora_apertura'],
            'hora_cierre'              =>$validateDataTienda['hora_cierre'],
            'llegada_previa'           =>$validateDataTienda['llegada_previa'],
            'estado'=>1,
        ]);
        
       $img->storeAs("public/images/tienda/{$tienda->id}", $validateDataTienda['imagen_tienda']);
    }


    public function Updatefototienda(Request $request, $id)
    {

        $tienda = Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message' => 'Imagen no encontrada.'], 404);
        }
        $validData = $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,gif,svg'
        ]);

        $img=$request->file('imagen');
        $validData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        
        $request->file('imagen')->storeAs("public/images/tienda/{$tienda->id}", $validData['imagen']);

        /*  if ($person->image != '') {
            unlink(storage_path("app/public/images/persons/{$person->userId}/" . $person->image));
        } */
        $tienda->imagen = $validData['imagen'];
        $tienda->save();
        return response()->json(['message' => 'Imagen actualizada'], 201);
    }



    public function updateRedes(Request $request, $id){
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda'],404);
        }
        $validateDataTienda=$request->validate([
            'instagram_user'           =>'nullable|string|max:255',
            'facebook_user'            =>'nullable|string|max:255',
            'tiktok_user'              =>'nullable|string|max:255',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message'=>'Las redes sociales se actualizaron de manera exitosa'],200);
    }

    public function updateDelivery(Request $request, $id){
        $tienda=Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message'=>'No se encontro ninguna tienda'],404);
        }
        $validateDataTienda=$request->validate([
            'is_delivery'              => 'required',
            'cargo_delivery'           => 'nullable',
            'tiempo_delivery_min'      => 'nullable',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message'=>'Las funciones de delivery se actualizaron de manera exitosa'],200);
    }

    public function getAllTiendasCategoria($id){
        $tienda=Tienda::where('id_categoria_tienda',$id)
        ->where('estado',1)
        ->get();
        if (is_null($tienda)) {
            return response()->json(['mesagge'=>'No se encontro ninguna tienda',400]);
        }
        return response()->json($tienda);
    }

    public function getTienda($id){
        $u = Tienda::where('id', $id)->get();
        return response()->json($u, 200);
    }


    
   /*  public function getCategotiaTiendas($id_tienda)
   {
        //Busca todos los productos por la tienda
        $categoria = DB::table('categorias_productos')
        ->select('categorias_productos.*')
        ->where('categorias_productos.id_tienda', $id_tienda)
        ->where('categorias_productos.estado', 1)
        ->get();

        return response($categoria, 200);
        
    }

    
    public function getProductoCategorias($id_categoria_productos){
        $productos=DB::table('productos')
        
        ->select('productos.*')
        ->where('productos.id_categoria_productos',$id_categoria_productos)
        ->where('productos.estado',1)
        ->get();
        return response()->json($productos);
    } */


    public function show( $id_tienda)
    {
        $tienda=Tienda::find($id_tienda);
        if (is_null($tienda)) {
            return response()->json(['mesagge'=>'No se encontro ninguna tienda', 404]);
        }
        return response()->json($tienda);
        
    }



    public function showCateProducto(){

        $data = Array();
        $categoria = DB::table('categorias_productos')
        ->select('categorias_productos.*')
        ->where('categorias_productos.estado', 1)
        ->get();

        foreach($categoria as $key => $p){

            $productos = DB::table('productos')
            ->select('productos.*')
            ->where('id_categoria_productos', $p->id)
            ->get();

            array_push($data, ['categoria' => $p,'data' => $productos]);

        }
        return response()->json($data, 200);
    }

}