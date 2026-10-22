<?php

namespace App\Http\Controllers;

use App\Models\Model_Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class Controller_Carrito extends Controller
{
    public function index(): View
    {
        $cart = session('cart', []);
        $products = Model_Producto::query()->whereIn('id', array_keys($cart))->get()->keyBy('id');
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = $products->get($id);
            if ($product) {
                $total += (float) $product->price * $quantity;
            }
        }

        return view('cart.index', compact('cart', 'products', 'total'));
    }

    public function store(Request $request, Model_Producto $producto): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['nullable', 'integer', 'min:1']]);
        $quantity = (int) ($validated['quantity'] ?? 1);

        abort_unless($producto->is_active, 404);

        $cart = session('cart', []);
        $newQuantity = ($cart[$producto->id] ?? 0) + $quantity;

        if ($newQuantity > $producto->stock) {
            return back()->withErrors(['quantity' => 'La cantidad solicitada supera el stock disponible.']);
        }

        $cart[$producto->id] = $newQuantity;
        session(['cart' => $cart]);

        return back()
            ->with('success', 'Producto agregado al carrito.')
            ->with('cart_open', true);
    }

    public function update(Request $request, Model_Producto $producto): RedirectResponse
    {
        $validated = $request->validate(['quantity' => ['required', 'integer', 'min:1']]);
        $quantity = (int) $validated['quantity'];

        if (! $producto->is_active || $quantity > $producto->stock) {
            return back()->withErrors(['quantity' => 'La cantidad solicitada supera el stock disponible.']);
        }

        $cart = session('cart', []);
        if (! array_key_exists($producto->id, $cart)) {
            abort(404);
        }

        $cart[$producto->id] = $quantity;
        session(['cart' => $cart]);

        return back()
            ->with('success', 'Cantidad actualizada.')
            ->with('cart_open', true);
    }

    public function destroy(Model_Producto $producto): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$producto->id]);
        session(['cart' => $cart]);

        return back()
            ->with('success', 'Producto eliminado del carrito.')
            ->with('cart_open', true);
    }
}
