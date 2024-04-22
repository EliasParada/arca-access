<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Products::all();
        if (Auth::check() && Auth::user()->admin == 1) {
            return view('adminproductos', compact('products'));
        }
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
        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('image'), $nombreImagen);
        }

        $producto = new Products();
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria = $request->categoria;
        $producto->proveedor = $request->proveedor;
        $producto->fecha = $request->fecha;
        $producto->precio = $request->precio;
        $producto->imagen = $nombreImagen;
        $producto->save();

        return redirect()->route('productos')->with('success', 'Producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $producto_id)
    {
        // Buscar el producto por ID
        $producto = Products::findOrFail($producto_id);

        // Actualizar los campos del producto
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->categoria = $request->categoria;
        $producto->proveedor = $request->proveedor;
        $producto->precio = $request->precio;
        $producto->fecha = $request->fecha;
        $producto->precio = $request->precio;

        // Si se subió una nueva imagen, actualizarla
        if ($request->hasFile('imagen')) {
            $nombreImagen = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('image'), $nombreImagen);
            $producto->imagen = $nombreImagen; // Cambia a 'imagen'
        }

        // Guardar los cambios
        $producto->save();

        return redirect()->route('productos')->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products, $producto_id)
    {
        $producto = Products::find($producto_id);
        $producto->delete();
        return redirect()->route('productos')->with('success', 'Categoría eliminada correctamente.');
    }
}
