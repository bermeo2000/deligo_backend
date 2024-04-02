<?php

namespace App\Http\Controllers;

use App\Models\TipoPeso;
use Illuminate\Http\Request;

class TipoPesoController extends Controller
{
    // * Obtiene todos los tipos de pesos
    public function index()
    {
        $data = TipoPeso::where('estado', 1)
        ->get();

        return response()->json($data, 200);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(TipoPeso $tipoPeso)
    {
        //
    }

    public function edit(TipoPeso $tipoPeso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoPeso $tipoPeso)
    {
        //
    }

    public function destroy(TipoPeso $tipoPeso)
    {
        //
    }
}
