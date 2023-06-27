<?php

namespace App\Http\Controllers;

use App\Models\CategoriaTienda;
use Illuminate\Http\Request;

class CategoriaTiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categoriaTienda = CategoriaTienda::where('estado',1)->get();
        return response()->json($categoriaTienda, 200);

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
    public function show(CategoriaTienda $categoriaTienda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoriaTienda $categoriaTienda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoriaTienda $categoriaTienda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaTienda $categoriaTienda)
    {
        //
    }
}
