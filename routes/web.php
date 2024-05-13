<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('register', [App\Http\Controllers\RegisterController::class, 'index'])->name('register');
Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.new');
Route::post('register', [App\Http\Controllers\RegisterController::class, 'register'])->name('register.new');
Route::post('logout', [App\Http\Controllers\LogoutContoller::class, 'logout'])->name('logout');

Route::get('pedidos', [App\Http\Controllers\FacturaController::class, 'index'])->name('pedidos');

Route::get('productos', [App\Http\Controllers\ProductsController::class, 'index'])->name('productos');
Route::post('productos', [App\Http\Controllers\ProductsController::class, 'store'])->name('productos.store');
Route::post('productos/{producto_id}', [App\Http\Controllers\ProductsController::class, 'update'])->name('productos.update');
Route::delete('productos/{producto_id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('productos.destroy');

Route::get('carrito', [App\Http\Controllers\CartController::class, 'index'])->name('carrito');
Route::post('carrito', [App\Http\Controllers\CartController::class, 'store'])->name('carrito.store');
Route::post('carrito/vaciar', [App\Http\Controllers\CartController::class, 'destroy'])->name('carrito.vaciar');
Route::post('carrito/{producto_id}', [App\Http\Controllers\CartController::class, 'update'])->name('carrito.eliminar');
Route::post('carrito/{producto_id}/incrementar', [App\Http\Controllers\CartController::class, 'incrementarCantidad'])->name('carrito.incrementar');
Route::post('carrito/{producto_id}/decrementar', [App\Http\Controllers\CartController::class, 'decrementarCantidad'])->name('carrito.decrementar');
Route::post('cobrar', [App\Http\Controllers\CartController::class, 'cobrar'])->name('cobrar');
Route::get('pago/{token}/factura/{ern}', [App\Http\Controllers\CartController::class, 'verificar'])->name('pago');

