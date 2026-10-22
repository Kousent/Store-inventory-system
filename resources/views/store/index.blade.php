@extends('layouts.public')

@section('title', 'Catálogo')

@section('content')
    <section @class([
        'grid overflow-hidden rounded-3xl border border-slate-200 shadow-lg shadow-slate-900/10',
        'bg-white lg:grid-cols-[minmax(0,0.9fr)_minmax(0,1.1fr)]' => $storeSettings->banner_path,
        'bg-gradient-to-br from-emerald-50 via-white to-sky-50' => ! $storeSettings->banner_path,
    ])>
        @if ($storeSettings->banner_path)
            <div class="relative order-1 min-h-[220px] bg-slate-100 sm:min-h-[300px] lg:order-2 lg:min-h-[420px]">
                <img src="{{ Storage::disk('public')->url($storeSettings->banner_path) }}" alt="Banner de {{ $storeSettings->store_name }}" class="absolute inset-0 size-full object-cover object-center">
            </div>
        @endif
        <div class="order-2 flex min-h-[320px] items-center p-6 sm:min-h-[360px] sm:p-10 lg:order-1 lg:min-h-[420px] lg:p-12">
            <div class="max-w-xl">
                <span class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-[0.16em] text-emerald-800">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.2 2.1 3-.1 1 2.8 2.5 1.7-1 2.8 1 2.8-2.5 1.7-1 2.8-3-.1L12 22l-2.2-2.1-3 .1-1-2.8-2.5-1.7 1-2.8-1-2.8 2.5-1.7 1-2.8 3 .1L12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12 2.2 2.2 4.8-4.8"/></svg>
                    Calidad y confianza
                </span>
                <h1 class="mt-4 text-3xl font-black leading-tight tracking-tight text-slate-950 sm:text-4xl">{{ $storeSettings->store_name }}</h1>
                <p class="mt-3 max-w-md text-base leading-7 text-slate-600">Encuentra tus productos favoritos en un solo lugar, con una experiencia de compra fácil y cercana.</p>
                <a href="#productos" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-800 px-5 py-3 font-bold text-white shadow-sm transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-700 focus:ring-offset-2">
                    Explorar catálogo
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            </div>
        </div>
    </section>

    <section id="productos" class="scroll-mt-28 pt-12">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.17em] text-[#4f91b7]">Selección especial</p>
                <h2 class="mt-1 text-3xl font-black tracking-tight text-slate-900">Descubre nuestros productos</h2>
                <p class="mt-2 text-slate-500">Calidad y buenos precios para tu hogar.</p>
            </div>
            <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-slate-500 shadow-sm">{{ $productos->total() }} productos</span>
        </div>
        @if ($productos->isEmpty())
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-600 shadow-sm">
                <span class="mx-auto grid size-16 place-items-center rounded-2xl bg-sky-50 text-[#4f91b7]">
                    <svg class="size-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14l1 12H4L5 8Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 9V6a3 3 0 0 1 6 0v3"/></svg>
                </span>
                <h3 class="mt-4 text-lg font-bold text-slate-800">Estamos preparando el catálogo</h3>
                <p class="mt-2">Pronto encontrarás productos disponibles para ti.</p>
            </div>
        @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($productos as $producto)
                <article class="group overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl hover:shadow-sky-900/10">
                    <a href="{{ route('products.show', $producto) }}" class="relative block overflow-hidden bg-gradient-to-br from-sky-50 to-slate-100">
                        @if ($producto->image)
                            <img src="{{ Storage::disk('public')->url($producto->image) }}" alt="{{ $producto->name }}" class="h-56 w-full object-contain p-5 transition duration-500 group-hover:scale-105">
                        @else
                            <div class="grid h-56 place-items-center text-6xl text-sky-700/30">
                                <svg class="size-16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                            </div>
                        @endif
                        <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-[#397ca2] shadow-sm">Calidad seleccionada</span>
                    </a>
                    <div class="p-5">
                        <h3 class="line-clamp-2 min-h-12 font-bold leading-6 text-slate-800">{{ $producto->name }}</h3>
                        <div class="mt-2 flex items-center justify-between gap-2">
                            <p class="text-2xl font-black text-[#4f91b7]">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price, 2) }}</p>
                            @if ($producto->stock > 0)
                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700">{{ $producto->stock }} disponibles</span>
                            @else
                                <span class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-bold text-amber-700">Agotado</span>
                            @endif
                        </div>
                        <div class="mt-4 grid grid-cols-[1fr_auto] gap-2">
                            <a href="{{ route('products.show', $producto) }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-sky-300 hover:bg-sky-50 hover:text-sky-800">Ver detalles</a>
                            @if ($producto->stock > 0)
                                <form method="POST" action="{{ route('carrito.store', $producto) }}">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button aria-label="Agregar {{ $producto->name }} al carrito" class="grid size-11 place-items-center rounded-xl bg-[#5c9ac1] text-white shadow-sm transition hover:bg-[#397ca2]">
                                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.1a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L21 8H6"/><path stroke-linecap="round" d="M10 11v5m-2.5-2.5h5"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $productos->links() }}</div>
        @endif
    </section>
@endsection
