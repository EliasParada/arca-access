<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Factura;
use App\Models\DetalleFactura;
use Illuminate\Support\Facades\Auth;
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

    public function metodo()
    {
        if (Auth::check()) {
            $carrito = session()->get('carrito', []);

            return view('metodo');
        }
    }
    public function cobrar(Request $request)
    {
        if (Auth::check()) {
            $carrito = session()->get('carrito', []);

            $total = 0;
            foreach ($carrito as $item) {
                $total += $item['precio_unidad'] * $item['cantidad'];
            }

            session()->put('carrito_old', $carrito);

            $fechaHora = date('YmdHis');
            $numeroAleatorio = rand(100, 999);
            $ern = "ARCA_ACCESS-$fechaHora-$numeroAleatorio";

            $factura = Factura::create([
                'nombre' => $ern,
                'usuario' => Auth::user()->id,
                'direccion' => $request->direccion,
                'metodo' => $request->metodo_pago,
                'total' => $total,
            ]);

            if ($request->metodo_pago == "pagadito") {
                if($this->pagadito->connect()) {
                    foreach ($carrito as $item) {
                        DetalleFactura::create([
                            'factura' => $factura->id,
                            'producto' => $item['producto_id'],
                            'cantidad' => $item['cantidad'],
                        ]);
                        $this->pagadito->add_detail($item['cantidad'], $item['nombre'], $item['precio_unidad']);
                    }

                    if (!$this->pagadito->exec_trans($ern)) {
                        return "ERROR:" . $this->pagadito->get_rs_code() . ": " . $this->pagadito->get_rs_message();
                    }
                } else {
                    return "ERROR:" . $this->pagadito->get_rs_code() . ": " . $this->pagadito->get_rs_message();
                }
            }

            foreach ($carrito as $item) {
                DetalleFactura::create([
                    'factura' => $factura->id,
                    'producto' => $item['producto_id'],
                    'cantidad' => $item['cantidad'],
                ]);
            }

            return redirect()->route('pedido', $ern);
        } else {
            return view('auth.login');
        }
    }

    public function pedido(Request $request, $ern)
    {
        $factura = Factura::where('nombre', $ern)->first();
        $detalles = DetalleFactura::where('factura', $factura->id)->get();

        session()->forget('carrito');

        return view('pago', ['estado' => $factura->metodo, 'factura' => $factura, 'detalles' => $detalles]);
    }
    public function verificar(Request $request, $token, $ern)
    {
        if ($this->pagadito->connect()) {
            if ($this->pagadito->get_status($token)) {
                $estado = $this->pagadito->get_rs_status();
                if ($estado == "COMPLETED") {
                    $factura = Factura::where('nombre', $ern)->first();
                    $detalles = DetalleFactura::where('factura', $factura->id)->get();

                    session()->forget('carrito');

                    return view('pago', ['estado' => $estado, 'factura' => $factura, 'detalles' => $detalles]);
                } elseif ($estado == "VERIFYING") {
                    return view('pago', ['estado' => $estado]);
                } elseif ($estado == "REVOKED") {
                    return view('pago', ['estado' => $estado]);
                } elseif ($estado == "FAILED") {
                    return view('pago', ['estado' => $estado]);
                } elseif ($estado == "CANCELED") {
                    return view('pago', ['estado' => $estado]);
                } elseif ($estado == "EXPIRED") {
                    return view('pago', ['estado' => $estado]);
                } else {
                    return view('pago', ['error' => 'Estado no válido']);
                }
            } else {
                return view('pago', ['error' => $this->pagadito->get_rs_code() . ': ' . $this->pagadito->get_rs_message()]);
            }
        } else {
            return view('pago', ['error' => $this->pagadito->get_rs_code() . ': ' . $this->pagadito->get_rs_message()]);
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
