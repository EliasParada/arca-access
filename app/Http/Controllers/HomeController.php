<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $carrito = session()->get('carrito', []);
        if ($request->has('search')) {
            $products = Products::where('nombre', 'LIKE', '%' . $request->search . '%')->get();
            return view('index', compact('products', 'carrito'));
        }

        $products = Products::all();
        return view('index', compact('products', 'carrito'));
    }
}
