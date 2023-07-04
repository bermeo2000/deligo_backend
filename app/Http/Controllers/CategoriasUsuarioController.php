<?php

namespace App\Http\Controllers;

use App\Models\CategoriasUsuario;
use Illuminate\Http\Request;

class CategoriasUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoriasUsuario = CategoriasUsuario::where('estado',1)->get();
        return response()->json($categoriasUsuario, 200);
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
    public function show(CategoriasUsuario $categoriasUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriasUsuario $categoriasUsuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriasUsuario $categoriasUsuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriasUsuario $categoriasUsuario)
    {
        //
    }
}
