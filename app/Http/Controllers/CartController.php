<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Lib\Services\Pagadito;
use Illuminate\Http\Request;

require_once(__DIR__. '../../../services/config.php');
require_once(__DIR__. '../../../services/lib/Pagadito.php');

class CartController extends Pagadito
{
    protected $pagadito;

    public function __construct()
    {
        $this->pagadito = new Pagadito(UID, WSK);
        
        if (SANDBOX) {
            $this->pagadito->mode_sandbox_on();
        }
    }

    public function index()
    {
        $carrito = session()->get('carrito', []);

        return view('carrito', ['carrito' => $carrito]);
    }

    function create()
    {
        //
    }

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

    public function show(Products $productos)
    {
        //
    }

    public function edit(Products $productos)
    {
        //
    }

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

    public function destroy(Products $productos)
    {
        session()->forget('carrito');
        return redirect()->back()->with('success', 'El carrito se ha vaciado correctamente');
    }

    public function cobrar()
    {
        $carrito = session()->get('carrito', []);

        session()->put('carrito_old', $carrito);

        $fechaHora = date('YmdHis');
        $numeroAleatorio = rand(100, 999);
        $ern = "ARCA_ACCESS-$fechaHora-$numeroAleatorio";

        if($this->pagadito->connect()) {
            foreach ($carrito as $item) {
                $this->pagadito->add_detail($item['cantidad'], $item['nombre'], $item['precio_unidad']);
            }

            if (!$this->pagadito->exec_trans($ern)) {
                return "ERROR:" . $this->pagadito->get_rs_code() . ": " . $this->pagadito->get_rs_message();
            }
        } else {
            return "ERROR:" . $this->pagadito->get_rs_code() . ": " . $this->pagadito->get_rs_message();
        }
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
