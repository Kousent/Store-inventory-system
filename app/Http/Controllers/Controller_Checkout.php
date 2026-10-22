<?php

namespace App\Http\Controllers;

use App\Models\Model_ConfiguracionTienda;
use App\Models\Model_Orden;
use App\Models\Model_Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class Controller_Checkout extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (empty(session('cart', []))) {
            return redirect()->route('carrito.index')->withErrors(['cart' => 'El carrito está vacío.']);
        }

        return view('checkout.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = session('cart', []);
        if ($cart === []) {
            return redirect()->route('carrito.index')->withErrors(['cart' => 'El carrito está vacío.']);
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'shipping_address' => ['required', 'string', 'max:2000'],
            'payment_method' => ['required', Rule::in(['cash_on_delivery', 'bank_transfer', 'card_on_delivery'])],
        ]);
        $currencyCode = Model_ConfiguracionTienda::query()->findOrFail(1)->currency_code;

        $order = DB::transaction(function () use ($cart, $validated, $request, $currencyCode): Model_Orden {
            $products = Model_Producto::query()
                ->whereIn('id', array_keys($cart))
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($products->count() !== count($cart)) {
                throw ValidationException::withMessages(['cart' => 'Uno o más productos ya no están disponibles.']);
            }

            $total = 0;
            foreach ($cart as $id => $quantity) {
                $product = $products->get($id);
                if (! $product->is_active || $quantity > $product->stock) {
                    throw ValidationException::withMessages(['cart' => "Stock insuficiente para {$product->name}."]);
                }
                $total += (int) round((float) $product->price * 100) * $quantity;
            }
            $total /= 100;

            $order = Model_Orden::create([
                ...$validated,
                'user_id' => $request->user()?->id,
                'status' => 'confirmed',
                'total' => $total,
                'currency_code' => $currencyCode,
            ]);

            foreach ($cart as $id => $quantity) {
                $product = $products->get($id);
                $subtotal = (int) round((float) $product->price * 100) * $quantity / 100;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);
            }

            return $order;
        });

        $request->session()->forget('cart');
        $request->session()->put('last_order_id', $order->id);

        return redirect()->route('checkout.success', $order);
    }

    public function success(Model_Orden $orden): View
    {
        abort_unless(session('last_order_id') === $orden->id, 404);
        session()->forget('last_order_id');

        return view('checkout.success', compact('orden'));
    }
}
