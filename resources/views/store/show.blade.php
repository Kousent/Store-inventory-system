@extends('layouts.public')

@section('title', $producto->name)

@section('content')
    <nav aria-label="Migas de pan" class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
        <a href="{{ route('home') }}" class="font-semibold text-[#4f91b7] hover:underline">Inicio</a>
        <span>/</span><a href="{{ route('home') }}" class="font-semibold text-[#4f91b7] hover:underline">Catálogo</a><span>/</span><span class="font-semibold text-slate-700">{{ $producto->name }}</span>
    </nav>
    <div class="mt-6 grid gap-8 lg:grid-cols-[0.95fr_1.05fr]">
        <div class="grid min-h-[360px] place-items-center overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:min-h-[500px]">
            @if ($producto->image)
                <img src="{{ Storage::disk('public')->url($producto->image) }}" alt="{{ $producto->name }}" class="max-h-[440px] w-full object-contain">
            @else
                <div class="grid size-full min-h-[320px] place-items-center rounded-3xl bg-gradient-to-br from-sky-50 to-slate-100 text-[#5c9ac1]">
                    <svg class="size-24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.1" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                </div>
            @endif
        </div>
        <div class="flex flex-col rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm sm:p-9">
            <span class="text-xs font-extrabold uppercase tracking-[0.18em] text-[#5c9ac1]">Selección de la tienda</span>
            <h1 class="mt-3 text-3xl font-black leading-tight tracking-tight sm:text-4xl">{{ $producto->name }}</h1>
            <p class="mt-5 text-4xl font-black text-[#5c9ac1]">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price, 2) }}</p>
            <p class="mt-5 whitespace-pre-line leading-7 text-slate-600">{{ $producto->description }}</p>
            <p class="mt-5 flex items-center gap-2 text-sm font-bold {{ $producto->stock ? 'text-emerald-700' : 'text-amber-700' }}">
                <span class="size-2 rounded-full {{ $producto->stock ? 'bg-emerald-500' : 'bg-amber-500' }}"></span>
                {{ $producto->stock ? "Disponible · {$producto->stock} en stock" : 'Producto agotado' }}
            </p>
            @if ($producto->stock > 0)
                <form method="POST" action="{{ route('carrito.store', $producto) }}" class="mt-7 grid gap-3 sm:grid-cols-[140px_1fr]">
                    @csrf
                    <div data-quantity-control class="flex items-center justify-between rounded-xl border border-slate-200 p-1">
                        <button type="button" data-step="-1" aria-label="Disminuir cantidad" class="grid size-10 place-items-center rounded-lg bg-sky-50 font-bold text-[#397ca2] hover:bg-sky-100">−</button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $producto->stock }}" required aria-label="Cantidad" class="w-12 border-0 p-0 text-center font-extrabold focus:ring-0">
                        <button type="button" data-step="1" aria-label="Aumentar cantidad" class="grid size-10 place-items-center rounded-lg bg-sky-50 font-bold text-[#397ca2] hover:bg-sky-100">+</button>
                    </div>
                    <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#5c9ac1] px-5 py-3 font-extrabold text-white shadow-lg shadow-sky-900/15 transition hover:-translate-y-0.5 hover:bg-[#397ca2]">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.2 11.1a2 2 0 0 0 2 1.6h8.6a2 2 0 0 0 2-1.6L21 8H6"/><path stroke-linecap="round" d="M10 11v5m-2.5-2.5h5"/></svg>
                        Agregar al carrito
                    </button>
                </form>
            @endif
            <div class="mt-8 grid grid-cols-2 gap-3 border-t border-slate-100 pt-6 sm:grid-cols-4">
                <div class="rounded-xl bg-sky-50 p-3 text-center">
                    <svg class="mx-auto size-6 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m12 3 2.2 2.1 3-.1 1 2.8 2.5 1.7-1 2.8 1 2.8-2.5 1.7-1 2.8-3-.1L12 22l-2.2-2.1-3 .1-1-2.8-2.5-1.7 1-2.8-1-2.8 2.5-1.7 1-2.8 3 .1L12 3Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m8.5 12 2.2 2.2 4.8-4.8"/></svg>
                    <p class="mt-2 text-xs font-bold text-slate-700">Calidad seleccionada</p>
                </div>
                <div class="rounded-xl bg-sky-50 p-3 text-center">
                    <svg class="mx-auto size-6 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v13a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 18.5v-13Z"/><path stroke-linecap="round" d="M8 8h8M8 12h8m-8 4h5"/></svg>
                    <p class="mt-2 text-xs font-bold text-slate-700">Compra sencilla</p>
                </div>
                <div class="rounded-xl bg-sky-50 p-3 text-center">
                    <svg class="mx-auto size-6 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 11.5a8.4 8.4 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.4 8.4 0 0 1-3.8-.9L3 21l1.9-5.7a8.4 8.4 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.4 8.4 0 0 1 3.8-.9h.5a8.5 8.5 0 0 1 8 8v.5Z"/></svg>
                    <p class="mt-2 text-xs font-bold text-slate-700">Atención cercana</p>
                </div>
                <div class="rounded-xl bg-sky-50 p-3 text-center">
                    <svg class="mx-auto size-6 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
                    <p class="mt-2 text-xs font-bold text-slate-700">Compra segura</p>
                </div>
            </div>
        </div>
    </div>
    <section aria-labelledby="related-products-title" class="mt-16 border-t border-slate-200 pt-10">
        <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-[#4f91b7]">Sigue explorando</p>
                <h2 id="related-products-title" class="mt-1 text-2xl font-black tracking-tight text-slate-900">
                    @if ($relacionadosPorCategoria)
                        Productos relacionados en {{ $producto->category }}
                    @else
                        Productos que te pueden interesar
                    @endif
                </h2>
            </div>
            <a href="{{ route('home') }}#productos" class="inline-flex items-center gap-2 text-sm font-bold text-[#397ca2] hover:text-[#24586f]">
                Ver catálogo completo
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
            </a>
        </div>
        @if ($relacionados->isNotEmpty())
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($relacionados as $relacionado)
                    <article class="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-sky-200 hover:shadow-lg">
                        <a href="{{ route('products.show', $relacionado) }}" aria-label="Ver más sobre {{ $relacionado->name }}" class="grid h-44 place-items-center bg-slate-50 p-4">
                            @if ($relacionado->image)
                                <img src="{{ Storage::disk('public')->url($relacionado->image) }}" alt="{{ $relacionado->name }}" loading="lazy" class="size-full object-contain transition duration-300 group-hover:scale-105">
                            @else
                                <svg class="size-12 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                            @endif
                        </a>
                        <div class="flex flex-1 flex-col p-4">
                            @if ($relacionado->category)
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400">{{ $relacionado->category }}</p>
                            @endif
                            <h3 class="mt-1 line-clamp-2 min-h-10 text-sm font-bold text-slate-800">{{ $relacionado->name }}</h3>
                            <p class="mt-2 font-extrabold text-[#397ca2]">{{ $storeSettings->currency_symbol }} {{ number_format((float) $relacionado->price, 2) }}</p>
                            <div class="mt-auto flex gap-2 pt-4">
                                <a href="{{ route('products.show', $relacionado) }}" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-bold text-slate-700 transition hover:border-sky-300 hover:bg-sky-50">Ver más</a>
                                @if ($relacionado->stock > 0)
                                    <form method="POST" action="{{ route('carrito.store', $relacionado) }}">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button aria-label="Agregar {{ $relacionado->name }} al carrito" class="rounded-lg bg-[#5c9ac1] px-3 py-2 text-xs font-bold text-white transition hover:bg-[#397ca2]">Añadir</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white/70 px-6 py-10 text-center">
                <p class="font-bold text-slate-800">Pronto encontrarás más productos aquí</p>
                <p class="mt-2 text-sm text-slate-500">Mientras tanto, puedes explorar todo el catálogo disponible.</p>
                <a href="{{ route('home') }}#productos" class="mt-5 inline-flex items-center gap-2 rounded-xl bg-[#5c9ac1] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#397ca2]">
                    Explorar catálogo
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                </a>
            </div>
        @endif
    </section>
@endsection
