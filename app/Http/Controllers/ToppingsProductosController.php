<?php

namespace App\Http\Controllers;

use App\Models\ToppingsProductos;
use Illuminate\Http\Request;

class ToppingsProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // esto lo voy a hacer para guardar el topping y la conexion con el producto
        // pero primero voy a esperar a hacer el front end
        
    }

    /**
     * Display the specified resource.
     */
    public function show(ToppingsProductos $toppingsProductos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ToppingsProductos $toppingsProductos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ToppingsProductos $toppingsProductos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ToppingsProductos $toppingsProductos)
    {
        //
    }
}
