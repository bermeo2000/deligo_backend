<?php

namespace App\Http\Controllers;

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
        $tienda_fav = $this->getTiendaFav($id);

        $home = Array();

        $tiendas=DB::table('tiendas')
        ->join('categoria_tiendas','tiendas.id_categoria_tienda','=','categoria_tiendas.id')
        ->select('tiendas.*', 'categoria_tiendas.nombre as categoria')
        ->where('tiendas.estado',1)
        ->get();
        $categoria_tiendas = CategoriaTienda::where('estado',1)->get();
        $productos = Producto::where('estado',1)->get();

        array_push(
            $home, [
                'categoria_tiendas' => $categoria_tiendas,
                'tiendas' => $tiendas,
                'productos' => $productos,
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
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }
        if ($this->validacionCodigo( $validData['codigo_referido_usuario'])) 
        {
            $this->aumentarVentas($validData['codigo_referido_usuario']);
            $user_ref->codigo_referido_usuario = $validData['codigo_referido_usuario'];
            $user_ref->save();
            
            return response()->json(['message' => 'Referido de usuario guardado correctamente'], 200);
        } 
        else 
        {
            return response()->json(['message' => 'El codigo ingresado no existe'], 400);
        }
        
      
    }
    private function validacionCodigo($codigo){
        $user= User::where('estado',1)
        ->where('codigo_referido',$codigo)
        ->get();
        if ($user->isEmpty()) {
            return false;
        }
        return true;
    }

    private function aumentarVentas($codigo){
        $user= User::where('estado',1)
        ->where('codigo_referido',$codigo)
        ->get();
        
        $tienda = Tienda::where('estado',1)
        ->where('id_propietario',$user[0]->id)
        ->get();
        if(count($tienda)>1)
        {
            //se debe definir si las ventas se aumentaran a la tienda original o se aumentaran a todas 
        }
        else
        {
            $tienda[0]->ventas=$tienda[0]->ventas+3;
            $tienda[0]->save();
        }
    }



    private function getTiendaFav($id_user){
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

}
