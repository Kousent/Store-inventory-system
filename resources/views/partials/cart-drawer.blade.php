<div data-cart-overlay data-open="{{ session()->has('cart_open') ? 'true' : 'false' }}" class="invisible fixed inset-0 z-50 bg-slate-950/50 opacity-0 backdrop-blur-sm transition duration-300" aria-hidden="true"></div>
<aside data-cart-drawer aria-label="Tu pedido" aria-modal="true" role="dialog" class="invisible fixed inset-y-0 right-0 z-[60] flex w-full max-w-md translate-x-full flex-col bg-white shadow-2xl transition duration-300 ease-out">
    <div class="flex items-center justify-between bg-[#5c9ac1] px-6 py-5 text-white">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-white/75">Resumen de compra</p>
            <h2 class="mt-1 text-xl font-extrabold">Tu pedido <span class="font-semibold text-white/80">({{ $cartCount }} {{ $cartCount === 1 ? 'producto' : 'productos' }})</span></h2>
        </div>
        <button type="button" data-close-cart aria-label="Cerrar carrito" class="grid size-10 place-items-center rounded-xl bg-white/15 transition hover:bg-white/25">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
        </button>
    </div>
    @if (count($cartItems))
        <div class="min-h-0 flex-1 overflow-y-auto px-5">
            @foreach ($cartItems as $item)
                @php($producto = $item['product'])
                <div class="flex gap-3 border-b border-slate-200 py-5">
                    <div class="grid size-14 shrink-0 place-items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                        @if ($producto->image)
                            <img src="{{ Storage::disk('public')->url($producto->image) }}" alt="" class="size-full object-contain p-1">
                        @else
                            <svg class="size-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-2">
                            <a href="{{ route('products.show', $producto) }}" class="line-clamp-2 text-sm font-bold text-slate-800 hover:text-sky-700">{{ $producto->name }}</a>
                            <form method="POST" action="{{ route('carrito.destroy', $producto) }}">
                                @csrf
                                @method('DELETE')
                                <button aria-label="Eliminar {{ $producto->name }}" class="rounded-md p-1 text-slate-400 hover:bg-rose-50 hover:text-rose-600">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M10 11v6m4-6v6M6 7l1 13h10l1-13M9 7V4h6v3"/></svg>
                                </button>
                            </form>
                        </div>
                        <p class="mt-1 text-xs font-medium text-slate-500">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price, 2) }} c/u</p>
                        <div class="mt-2 flex items-center justify-between">
                            <form method="POST" action="{{ route('carrito.update', $producto) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PUT')
                                <button type="button" data-quantity-step="-1" aria-label="Disminuir cantidad" class="grid size-7 place-items-center rounded-lg border border-slate-200 font-bold text-sky-700 hover:bg-sky-50">−</button>
                                <input type="number" name="quantity" min="1" max="{{ $producto->stock }}" value="{{ $item['quantity'] }}" aria-label="Cantidad de {{ $producto->name }}" class="w-10 border-0 p-0 text-center text-sm font-bold focus:ring-0">
                                <button type="button" data-quantity-step="1" aria-label="Aumentar cantidad" class="grid size-7 place-items-center rounded-lg border border-slate-200 font-bold text-sky-700 hover:bg-sky-50">+</button>
                            </form>
                            <span class="text-sm font-extrabold text-slate-800">{{ $storeSettings->currency_symbol }} {{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="border-t border-slate-200 bg-[#f4f8f9] p-5">
            <div class="flex items-center justify-between text-lg font-extrabold">
                <span>Total</span>
                <span class="text-[#4f91b7]">{{ $storeSettings->currency_symbol }} {{ number_format($cartTotal, 2) }}</span>
            </div>
            <p class="mt-1 text-xs text-slate-500">Impuestos y envío se confirman al finalizar.</p>
            <a href="{{ route('checkout.create') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#5c9ac1] px-5 py-3.5 font-bold text-white shadow-lg shadow-sky-800/15 transition hover:bg-[#397ca2]">
                Continuar con mi pedido
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
            <a href="{{ route('carrito.index') }}" class="mt-3 inline-flex w-full justify-center py-1 text-sm font-semibold text-slate-500 hover:text-sky-700">Ver carrito completo</a>
        </div>
    @else
        <div class="flex flex-1 flex-col items-center justify-center px-8 text-center">
            <span class="grid size-20 place-items-center rounded-full bg-sky-50 text-[#5c9ac1]">
                <svg class="size-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.1a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
            </span>
            <h3 class="mt-5 text-lg font-bold">Tu carrito está esperando</h3>
            <p class="mt-2 text-sm text-slate-500">Agrega productos y aquí podrás revisar tu pedido.</p>
            <a href="{{ route('home') }}" data-close-cart class="mt-5 rounded-xl bg-[#5c9ac1] px-5 py-3 text-sm font-bold text-white hover:bg-[#397ca2]">Explorar catálogo</a>
        </div>
    @endif
</aside>
