<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Products::all();
        $carrito = session()->get('carrito', []);
        return view('index', compact('products', 'carrito'));
    }
}
