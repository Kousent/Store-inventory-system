<?php

use App\Http\Controllers\Admin\Controller_ConfiguracionTienda;
use App\Http\Controllers\Admin\Controller_Inicio;
use App\Http\Controllers\Admin\Controller_Perfil;
use App\Http\Controllers\Admin\Controller_Producto as AdminProductoController;
use App\Http\Controllers\Auth\Controller_Sesion;
use App\Http\Controllers\Controller_Carrito;
use App\Http\Controllers\Controller_Checkout;
use App\Http\Controllers\Controller_Producto;
use App\Models\Model_Producto;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controller_Producto::class, 'index'])->name('home');
Route::get('/products/{producto}', [Controller_Producto::class, 'show'])->name('products.show');

Route::get('/carrito', [Controller_Carrito::class, 'index'])->name('carrito.index');
Route::post('/carrito/{producto}', [Controller_Carrito::class, 'store'])->name('carrito.store');
Route::put('/carrito/{producto}', [Controller_Carrito::class, 'update'])->name('carrito.update');
Route::delete('/carrito/{producto}', [Controller_Carrito::class, 'destroy'])->name('carrito.destroy');

Route::get('/checkout', [Controller_Checkout::class, 'create'])->name('checkout.create');
Route::post('/checkout', [Controller_Checkout::class, 'store'])->name('checkout.store');
Route::get('/checkout/confirmacion/{orden}', [Controller_Checkout::class, 'success'])->name('checkout.success');

Route::middleware('guest')->group(function () {
    Route::get('/login', [Controller_Sesion::class, 'create'])->name('login');
    Route::post('/login', [Controller_Sesion::class, 'store'])->middleware('throttle:10,1')->name('login.store');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Controller_Inicio::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductoController::class)
        ->except('show')
        ->parameters(['products' => 'producto']);
    Route::get('/perfil', [Controller_Perfil::class, 'edit'])->name('profile.edit');
    Route::put('/perfil', [Controller_Perfil::class, 'update'])->name('profile.update');
    Route::get('/configuracion-tienda', [Controller_ConfiguracionTienda::class, 'edit'])->name('store-settings.edit');
    Route::put('/configuracion-tienda', [Controller_ConfiguracionTienda::class, 'update'])->name('store-settings.update');
    Route::post('/logout', [Controller_Sesion::class, 'destroy'])->name('logout');
});

Route::model('producto', Model_Producto::class);
