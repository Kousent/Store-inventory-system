<?php

namespace App\Providers;

use App\Models\Model_ConfiguracionTienda;
use App\Models\Model_Producto;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['store.*', 'admin.*', 'auth.login', 'cart.index', 'checkout.*'], function ($view): void {
            $view->with('storeSettings', Model_ConfiguracionTienda::query()->findOrFail(1));
        });

        View::composer('layouts.public', function ($view): void {
            $cart = session('cart', []);
            $products = Model_Producto::query()
                ->whereIn('id', array_keys($cart))
                ->get()
                ->keyBy('id');

            $cartItems = [];
            $cartTotal = 0;
            $cartCount = 0;

            foreach ($cart as $id => $quantity) {
                $product = $products->get($id);

                if (! $product) {
                    continue;
                }

                $subtotal = (int) round((float) $product->price * 100) * $quantity / 100;
                $cartItems[] = compact('product', 'quantity', 'subtotal');
                $cartTotal += $subtotal;
                $cartCount += $quantity;
            }

            $view->with(compact('cartItems', 'cartTotal', 'cartCount'));
        });
    }
}
