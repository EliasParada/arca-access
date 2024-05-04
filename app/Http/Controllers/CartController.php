<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrito = session()->get('carrito', []);

        return view('carrito', ['carrito' => $carrito]);
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
        $producto_id = $request->input('id');

        $producto = Products::find($producto_id);

        if (!$producto) {
            dd($producto_id);
            return redirect()->back()->with('error', 'El producto seleccionado no existe');
        }

        $carrito = session()->get('carrito', []);

        foreach ($carrito as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                $carrito[$key]['cantidad'] += 1;
                session()->put('carrito', $carrito);
                return redirect()->back()->with('success', 'Cantidad actualizada en el carrito');
            }
        }


        $producto = [
            'producto_id' => $producto_id,
            'nombre' => $producto->nombre,
            'precio_unidad' => $producto->precio,
            'imagenes' => $producto->imagen,
            'cantidad' => 1,
        ];

        $carrito[] = $producto;

        session()->put('carrito', $carrito);

        return redirect()->back()->with('success', 'Producto agregado al carrito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $productos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $productos, $producto_id)
    {
        $carrito = session()->get('carrito', []);

        $indiceProducto = array_search($producto_id, array_column($carrito, 'producto_id'));

        if ($indiceProducto !== false && $indiceProducto > 0) {
            unset($carrito[$indiceProducto]);
            session()->put('carrito', $carrito);
        } else {
            session()->forget('carrito');
        }

        return redirect()->back()->with('delete', 'Producto eliminado del carrito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products     $productos)
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'El carrito se ha vaciado correctamente');
    }

    public function incrementarCantidad($producto_id)
    {
        $carrito = session()->get('carrito', []);

        foreach ($carrito as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                $carrito[$key]['cantidad'] += 1;
                session()->put('carrito', $carrito);
                return response()->json(['cantidad' => $carrito[$key]['cantidad']]);
            }
        }

        return response()->json(['error' => 'Producto no encontrado'], 404);
    }

    public function decrementarCantidad($producto_id)
    {
        $carrito = session()->get('carrito', []);

        foreach ($carrito as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                if ($carrito[$key]['cantidad'] > 1) {
                    $carrito[$key]['cantidad'] -= 1;
                    session()->put('carrito', $carrito);
                    return response()->json(['cantidad' => $carrito[$key]['cantidad']]);
                } else {
                    return response()->json(['error' => 'La cantidad no puede ser menor que 1'], 400);
                }
            }
        }

        return response()->json(['error' => 'Producto no encontrado'], 404);
    }

}
