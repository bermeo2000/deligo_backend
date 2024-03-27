<?php

namespace App\Http\Controllers;

use App\Models\CategoriasProductos;
use App\Models\CategoriaTienda;
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
        $tienda = Tienda::where('estado', 1)->get();
        if (count($tienda) == 0) {
            return response()->json('no existen tienda', 404);
        }
        return response()->json($tienda, 200);
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
            'nombre_tienda' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'celular' => 'required|string|max:255',
            'descripcion' => 'nullable',
            /* 'lat'                      =>'nullable',
            'lng'                      =>'nullable', */

        ]);
        $tienda->nombre_tienda = $validateData['nombre_tienda'];
        $tienda->ciudad = $validateData['ciudad'];
        $tienda->direccion = $validateData['direccion'];
        $tienda->celular = $validateData['celular'];
        $tienda->descripcion = $validateData['descripcion'];
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

    public function destroy($id)
    {
        $tienda = Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message' => 'tienda no encontrada'], 404);
        }
        $tienda->estado = 0;
        $tienda->save();

        return response()->json("La tienda se elimino con exito", 200);
    }




public function updateuser(Request $request, string $id_usuario)
{
    $user = User::find($id_usuario);
    if (is_null($id_usuario)) {
        return response()->json(['message' => 'Usuario encontrado'], 404);
    }
    $validateData = $request->validate([
        'nombre'   => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'ciudad'   =>'required|string|max:255',
        'cedula'   =>'required|string|max:255',
        'telefono' =>'required|string|max:255',
        'imagen' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
        'id_codigo_pais' => 'required',
        'id_tipo_usuario' => 'required',

    ]);
    $codigo = $this->generarCodigo($validateData['nombre']);
        while (User::where('codigo_referido', $codigo)->exists()) {
            $codigo = $this->generarCodigo($validateData['nombre']);
        }
        if (isset($validateData['imagen'])) {
            $validateData['imagen'] = $request->file('imagen')->storePublicly("public/images/usuario");
        } else {
            $validateData['imagen'] = null;
        }
    
    $user->nombre=$validateData['nombre'];
    $user->apellido=$validateData['apellido'];
    $user->ciudad=$validateData['ciudad'];
    $user->cedula=$validateData['cedula'];
    $user->telefono=$validateData['telefono'];
    $user->id_tipo_usuario=$validateData['id_tipo_usuario'];
    $user->id_codigo_pais=$validateData['id_codigo_pais'];
    $user->ventas=100;
    $user->imagen= $validateData['imagen'];
    $user->codigo_referido=$codigo;
    $user->codigo_referido_usuario=$user->codigo_referido_usuario==null?$codigo:$user->codigo_referido_usuario;

  
    $user->save();
    $this->storeTienda($request, $user);
    return response()->json(['message' => 'Usuario actualizado'], 201);
}




    // * Guarda el emprendedor 
    public function storeEmprendedor(Request $request)
    {
        $validateData = $request->validate([

            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            // TODO tener en cuenta la posibilidad de telefono personal y de la tienda
            'telefonoPersonal' => 'required|string|min:10',

            // ! Ya no se va a pedir en el registro
            /* 'imagen' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'cedula' => 'required|string|max:255',
            'id_codigo_pais' => 'required',
            'id_tipo_usuario' => 'required',
            'is_categoria_selec' => 'required', */

        ]);

        // * Guardado de imagen
        /* if (isset($validateData['imagen'])) {
            $validateData['imagen'] = $request->file('imagen')->storePublicly("public/images/usuario");
        } else {
            $validateData['imagen'] = null;
        } */

        $codigo = $this->generarCodigo($validateData['nombre']);
        while (User::where('codigo_referido', $codigo)->exists()) {
            $codigo = $this->generarCodigo($validateData['nombre']);
        }

        //Crea el emprendedor
        $emprendedor = User::create([
            'nombre' => $validateData['nombre'],
            'apellido' => $validateData['apellido'],
            'email' => $validateData['email'],
            'password' => $validateData['password'],
            'ciudad' => $validateData['ciudad'],
            'telefono' => $validateData['telefonoPersonal'],
            'id_codigo_pais' => 1,
            'id_tipo_usuario' => 2,
            'codigo_referido' => $codigo,
            'codigo_referido_usuario' => $codigo,
            'ventas' => 100,
            'estado' => 1,
        ]);

        $this->storeTienda($request, $emprendedor);

        return response()->json(['message' => 'Tienda creada con éxito'], 200);
    }

    public function generarCodigo($nombre)
    {
        $primerosDigitosNombre = substr($nombre, 0, 3);
        $numAleatorios = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
        $codigo = "DG-" . $primerosDigitosNombre . $numAleatorios;
        return $codigo;
    }

    public function storeTienda($request, $usuario)
    {
        $validateDataTienda = $request->validate([
            'nombre_tienda' => 'required|string|max:255',
            'id_categoria_tienda' => 'required',
            'ciudad' => 'required|string|max:255',
            'celular' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'is_delivery' => 'required',
            'cargo_delivery' => 'nullable',
            'tiempo_delivery_min' => 'nullable',
            'descripcion' => 'nullable',
            /* 'imagen_tienda' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048', */
            'hora_apertura' => 'nullable',
            'hora_cierre' => 'nullable',
        ]);

        // * Guardado de imagen
        /* if (isset($validateDataTienda['imagen_tienda'])) {
            $validateDataTienda['imagen_tienda'] = $request->file('imagen_tienda')->storePublicly("public/images/tienda");
        } else {
            $validateDataTienda['imagen_tienda'] = null;
        } */

        $tienda = Tienda::create([
            'nombre_tienda' => $validateDataTienda['nombre_tienda'],
            'id_propietario' => $usuario->id,
            'id_categoria_tienda' => $validateDataTienda['id_categoria_tienda'],
            'ciudad' => $validateDataTienda['ciudad'],
            'direccion' => $validateDataTienda['direccion'],
            'celular' => $validateDataTienda['celular'],
            'id_codigo_pais' => 1,
            'is_delivery' => $validateDataTienda['is_delivery'],
            'cargo_delivery' => $validateDataTienda['cargo_delivery'],
            'tiempo_delivery_min' => $validateDataTienda['tiempo_delivery_min'],
            'puntuacion' => 0,
            'descripcion' => $validateDataTienda['descripcion'],
            /* 'imagen' => $validateDataTienda['imagen_tienda'], */
            'hora_apertura' => $validateDataTienda['hora_apertura'],
            'hora_cierre' => $validateDataTienda['hora_cierre'],
            // TODO poner llegada previa en algun lado del dashboard cuando sea de tipo servicio
            /* 'llegada_previa' => $validateDataTienda['llegada_previa'], */
            'estado' => 1,
        ]);

        $cat_tienda = CategoriaTienda::where('id', $tienda->id_categoria_tienda)->get();

        $cat_p = CategoriasProductos::create([
            'descripcion' => $cat_tienda[0]->nombre,
            'id_tienda' => $tienda->id,
            'estado' => 1
        ]);

        // ? Aquí debería haber un return para validar en el otro lado si hay un error ?

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

        $validData['imagen'] = $request->file('imagen')->storePublicly("public/images/tienda");

        $tienda->imagen = $validData['imagen'];
        $tienda->save();
        return response()->json(['message' => 'Imagen actualizada'], 201);
    }



    public function updateRedes(Request $request, $id)
    {
        $tienda = Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message' => 'No se encontro ninguna tienda'], 404);
        }
        $validateDataTienda = $request->validate([
            'instagram_user' => 'nullable|string|max:255',
            'facebook_user' => 'nullable|string|max:255',
            'tiktok_user' => 'nullable|string|max:255',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message' => 'Las redes sociales se actualizaron de manera exitosa'], 200);
    }

    public function updateDelivery(Request $request, $id)
    {
        $tienda = Tienda::find($id);
        if (is_null($tienda)) {
            return response()->json(['message' => 'No se encontro ninguna tienda'], 404);
        }
        $validateDataTienda = $request->validate([
            'is_delivery' => 'required',
            'cargo_delivery' => 'nullable',
            'tiempo_delivery_min' => 'nullable',
        ]);
        $tienda->fill($validateDataTienda);
        $tienda->save();
        return response()->json(['message' => 'Las funciones de delivery se actualizaron de manera exitosa'], 200);
    }

    public function getAllTiendasCategoria($id)
    {
        $tienda = Tienda::where('id_categoria_tienda', $id)
            ->where('estado', 1)
            ->get();
        if (is_null($tienda)) {
            return response()->json(['mesagge' => 'No se encontro ninguna tienda', 400]);
        }
        return response()->json($tienda);
    }

    public function getTienda($id)
    {
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


    public function show($id)
    {
        $tienda=DB::table('tiendas')
        ->join('categoria_tiendas','tiendas.id_categoria_tienda','=','categoria_tiendas.id')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('tiendas.estado',1)
        ->where('tiendas.id', $id)
        ->get();

        /* $tienda = Tienda::find($id); */

        if (count($tienda) == 0) {
            return response()->json(['mesagge' => 'No se encontro ninguna tienda', 404]);
        }

        return response()->json($tienda);

    }

    public function showCateProducto($id)
    {

        $data = array();
        $categoria = DB::table('categorias_productos')
            ->select('categorias_productos.*')
            ->where('categorias_productos.estado', 1)
            ->where('categorias_productos.id_tienda',$id)
            ->get();

        foreach ($categoria as $key => $p) {

            $productos = DB::table('productos')
            ->join('tiendas','tiendas.id','=', 'productos.id_tienda')
                ->select('productos.*', 'tiendas.nombre_tienda as nombreTienda')

                ->where('id_categoria_productos', $p->id)
                ->where('productos.estado', 1)
                ->get();
            $promocion_productos = DB::table('promocion_productos')
                ->join('productos', 'promocion_productos.id_producto', '=', 'productos.id')
                ->join('tiendas','tiendas.id','=', 'productos.id_tienda')
                ->select('promocion_productos.*', 
                'productos.nombre as nombre_promo', 'productos.descripcion as descripcion', 'productos.precio as precio', 'productos.imagen', 'productos.is_topping','productos.puntuacion as puntuacion',
                'tiendas.nombre_tienda as nombreTienda', )
               // ->where('promocion_productos.estado', 1)
                ->where('productos.estado', 1)
                ->where('productos.id_categoria_productos', $p->id)
                ->get();

            array_push($data, ['categoria' => $p, 'productos' => $productos, 'promociones'=>$promocion_productos]);

        }
        return response()->json($data, 200);
    }

}