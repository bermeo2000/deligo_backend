<?php

namespace App\Http\Controllers;
use App\Models\PromocionProducto;
use App\Models\CategoriaTienda;
use App\Models\Producto;
use App\Models\User;
use App\Models\Tienda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    // En este controller estan presentes las consultas para el home
    // con el fin de optimizar y hacer una sola petición

    public function getHome($id){
        $tienda_fav = $this->getTiendaFav_DB($id);
    
        $home = Array();
    
        $tiendas = DB::table('tiendas')
            ->join('categoria_tiendas', 'tiendas.id_categoria_tienda', '=', 'categoria_tiendas.id')
            ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
            ->where('tiendas.estado', 1)
            ->get();
    
            $categoria_tiendas = CategoriaTienda::where('estado',1)->get();
        $productos = Producto::where('estado', 1)->get();
        $promocion_productos = DB::table('promocion_productos')
            ->join('productos', 'promocion_productos.id_producto', '=', 'productos.id')
            ->select('promocion_productos.*', 'productos.nombre as nombreprom', 'productos.imagen')
            ->where('promocion_productos.estado', 1)
            ->get();
    
        array_push(
            $home, [
                'categoria_tiendas' => $categoria_tiendas,
                'tiendas' => $tiendas,
                'productos' => $productos,
                'promocion' => $promocion_productos,
                'tienda_fav' => $tienda_fav
            ]
        );
    
        return response()->json($home, 200);
    }

    public function saveReferidoUsuario(Request $request){
        $validData = $request->validate([
            'id_user' => 'required',
            'codigo_referido_usuario' => 'required'
        ]);

        $user_ref = User::find($validData['id_user']);
        if (is_null($user_ref)) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        if ($this->validacionCodigo( $validData['codigo_referido_usuario'])){

            $this->aumentarVentas($validData['codigo_referido_usuario']);
            $user_ref->codigo_referido_usuario = $validData['codigo_referido_usuario'];
            /* 
                Suma de PuntosGO
                Actualmente se suman 100 pero esto cambiaría dependiendo de lo que se defina 16/9/23
            */
            $user_ref->puntos_go = 100;
            $user_ref->save();
            
            return response()->json(['message' => 'Referido de usuario guardado correctamente'], 200);
        } 
        else 
        {
            return response()->json(['message' => 'El codigo ingresado no existe. Vuelve a intentarlo.'], 404);
        }
        
      
    }
    private function validacionCodigo($codigo){
        /* 
        Esta función valida que el codigo que el usuario ha ingresado exista
        es decir que sea el mismo de un emprendedor, para así asignarlo 
        y mostrar la tienda como fav
        */
        $user= User::where('estado',1)
        ->where('codigo_referido', $codigo)
        ->get();
        if ($user->isEmpty()){
            return false;
        }
        return true;
    }
    private function aumentarVentas($codigo){
        $user= User::where('estado',1)
        ->where('codigo_referido',$codigo)
        ->get();
        if ($user->isEmpty()) {
            return response()->json("El codigo de referido no existe", 404);
        }
        $user[0]->ventas=$user[0]->ventas+3;
        $user[0]->save();  
    }

    private function getTiendaFav_DB($id_user){
        // Como funcionan los errores aquí
        /* 
            Para manejarlo en frontend:
            1 = Cuando por lo que sea exista un problema con el id del usuario retorna esta opción
            2 = Cuando por lo que sea no exista el emprendedor con ese código de usuario retorna esta opción
            3 = Cuando exista algún problema con la consulta de la tienda retorna esta opción
        */
        // Quizá no es el mejor manejo de errores pero sirve de momento
        $user = DB::table('users')
        ->where('users.id', $id_user)
        ->get();
        if($user == '[]'){
            $tienda_fav = 1;
            return $tienda_fav;
        }

        $emp = DB::table('users')
        ->where('users.codigo_referido', $user[0]->codigo_referido_usuario)
        ->get();
        if($emp == '[]'){
            $tienda_fav = 1;
            return $tienda_fav;
        }

        $tienda_fav = DB::table('tiendas')
        ->where('tiendas.id_propietario', $emp[0]->id)
        ->get();
        if($tienda_fav == '[]' ){
            $tienda_fav = 1;
            return $tienda_fav;
        }
        return $tienda_fav;
    }

    public function getTiendaFav($id)
    {
        $tienda_fav = $this->getTiendaFav_DB($id);
        return response()->json($tienda_fav, 200);
    }

}
