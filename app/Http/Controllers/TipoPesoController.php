<?php

namespace App\Http\Controllers;

use App\Models\TipoPeso;
use Illuminate\Http\Request;

class TipoPesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //todos los tipos de pesos

        $data = TipoPeso::where('estado', 1)
        ->get();

        return response()->json($data, 200);

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
    public function show(TipoPeso $tipoPeso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoPeso $tipoPeso)
    {
        //
    }
}
