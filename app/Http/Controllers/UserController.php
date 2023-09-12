<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Tienda;
use App\Models\User;
use App\Models\CategoriasUsuario;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('estado',1)->get();
        return response()->json($user, 200);

        //esto no se usa
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    


    


    public function register(Request $request)
    {
      /*   return response()->json(['message' => $request], 200); */
        $validateData = $request->validate([
            'nombre'            => 'required|string|max:255',
            'apellido'          => 'required|string|max:255',
            'ciudad'            => 'required|string|max:255',
            'email'             => 'required|string|max:255',
            'password'          => 'required|string|max:255',
            'id_tipo_usuario'   => 'required',
            'is_categoria_selec'=>'required',
        ]);
        
        $type=2;
        $user = User::create([
            'nombre'            =>$validateData['nombre'],
            'apellido'          =>$validateData['apellido'],
            'ciudad'            =>$validateData['ciudad'],
            'email'             =>$validateData['email'],
            'password'          =>$validateData['password'],
            'id_tipo_usuario'   =>$validateData['id_tipo_usuario'],
            'is_categoria_selec'=>$validateData['is_categoria_selec'],
            'estado'=>1,

          
        ]);
        
        if ($validateData['is_categoria_selec']==1) {
            $array = explode(",",$request->id_categoria_tienda);

            for ($i = 0; $i < count($array); $i++) {
                $aux=$array[$i];
                CategoriasUsuario::create([
                    'estado' => 1,
                    'id_usuario' => $user->id,
                    'id_categoria_tienda' => $aux,
                ]);
            }
        } 

        return response()->json(['message' => 'Usuario registrado'], 200);
    }


    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Usuario encontrado'], 404);
        }
        $validateData = $request->validate([
            'nombre'   => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'ciudad'   =>'required|string|max:255',
            'cedula'   =>'required|string|max:255',
            'telefono' =>'required|string|max:255',
           // 'imagen'=>'required'
        ]);
        $user->nombre=$validateData['nombre'];
        $user->apellido=$validateData['apellido'];
        $user->ciudad=$validateData['ciudad'];
        $user->cedula=$validateData['cedula'];
        $user->telefono=$validateData['telefono'];
       
        $user->save();
        return response()->json(['message' => 'Usuario actualizado'], 201);
    }

    public function updatUserEmail(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $validateData = $request->validate([
            'email' => 'required|email|max:50|unique:users',
        ]);
        $user->email = $validateData['email'];
        $user->save();
        return response()->json(['message' => 'Email actualizado'], 201);
    }

    public function updateditPassword(Request $request, $id)
    {
        $user = User::find($id);
        if(is_null($user)){
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        $validateData = $request->validate([
            'password' => 'required|string|max:50|unique:users',
        ]);
        $validateData['password'] = Hash::make($validateData['password']);
        $user->password = $validateData['password'];
        $user->save();
        return response()->json(['message' => 'Contraseña actualizada'], 201);
    }


    public function updatUserImage(Request $request, $id)
    {

        $user = User::find($id);
        if (is_null($user)) {
            return response()->json(['message' => 'Imagen no encontrada.'], 404);
        }
        $validData = $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,gif,svg'
        ]);

        $img=$request->file('imagen');
        $validData['imagen'] = time().'.'.$img->getClientOriginalExtension();
        
        $request->file('imagen')->storeAs("public/images/Usuario/{$user->id}", $validData['imagen']);

        $user->imagen = $validData['imagen'];
        $user->save();
        return response()->json(['message' => 'Imagen actualizada'], 201);
    }

    public function getUser($id){
        $u = User::where('id', $id)->get();
        return response()->json($u, 200);
    }

   
}
