@extends('layouts.public')

@section('title', 'Carrito')

@section('content')
    <div class="flex items-end justify-between gap-4">
        <div><p class="text-sm font-bold uppercase tracking-[0.16em] text-[#4f91b7]">Tu selección</p><h1 class="mt-1 text-3xl font-black">Tu carrito</h1></div>
        <a href="{{ route('home') }}" class="text-sm font-bold text-[#397ca2] hover:underline">Seguir comprando</a>
    </div>
    @if (empty($cart))
        <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-12 text-center shadow-sm">
            <span class="mx-auto grid size-20 place-items-center rounded-full bg-sky-50 text-[#5c9ac1]">
                <svg class="size-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.1a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L21 8H6"/><circle cx="10" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
            </span>
            <h2 class="mt-5 text-xl font-black">Todavía no agregas productos</h2>
            <p class="mt-2 text-slate-500">Explora el catálogo y agrega tus favoritos a la cesta.</p>
            <a href="{{ route('home') }}" class="mt-5 inline-flex rounded-xl bg-[#5c9ac1] px-5 py-3 font-bold text-white hover:bg-[#397ca2]">Explorar catálogo</a>
        </div>
    @else
        <div class="mt-6 overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
            <table class="w-full min-w-[650px] text-left">
                <thead class="bg-[#f1fbfc] text-xs font-extrabold uppercase tracking-wide text-slate-500">
                    <tr><th class="px-5 py-4">Producto</th><th class="px-5 py-4">Precio</th><th class="px-5 py-4">Cantidad</th><th class="px-5 py-4">Subtotal</th><th class="px-5 py-4">Acciones</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($cart as $id => $quantity)
                        @php($producto = $products->get($id))
                        @if ($producto)
                            <tr>
                                <td class="px-5 py-4 font-bold">{{ $producto->name }}</td>
                                <td class="px-5 py-4">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price, 2) }}</td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('carrito.update', $producto) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" min="1" max="{{ $producto->stock }}" value="{{ $quantity }}" required class="w-20 rounded-md border-slate-300">
                                        <button class="text-sm font-bold text-[#397ca2] hover:underline">Actualizar</button>
                                    </form>
                                </td>
                                <td class="px-5 py-4 font-semibold">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price * $quantity, 2) }}</td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('carrito.destroy', $producto) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-sm font-semibold text-red-700 hover:underline">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot><tr><td colspan="3" class="px-5 py-5 text-right text-lg font-bold">Total</td><td colspan="2" class="px-5 py-5 text-lg font-bold text-indigo-700">{{ $storeSettings->currency_symbol }} {{ number_format($total, 2) }}</td></tr></tfoot>
            </table>
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('checkout.create') }}" class="rounded-xl bg-[#5c9ac1] px-6 py-3 font-extrabold text-white shadow-lg shadow-sky-900/15 transition hover:-translate-y-0.5 hover:bg-[#397ca2]">Continuar con la compra</a>
        </div>
    @endif
@endsection
