@extends('layouts.admin')

@section('title', 'Panel')

@section('content')
    <section class="relative isolate overflow-hidden rounded-3xl bg-gradient-to-r from-[#176a91] to-[#4e73bb] p-7 text-white shadow-xl shadow-sky-900/10 sm:p-9">
        <div aria-hidden="true" class="absolute -right-16 -top-28 -z-10 size-80 rounded-full border-[36px] border-white/10"></div>
        <p class="text-sm font-bold text-sky-100">Resumen de tu tienda</p>
        <h2 class="mt-2 text-3xl font-black sm:text-4xl">¡Hola, {{ auth()->user()->name }}!</h2>
        <p class="mt-2 max-w-xl text-sm leading-6 text-white/80">Aquí tienes una vista rápida del catálogo y de la actividad reciente de tu negocio.</p>
    </section>
    <div class="mt-6 grid min-w-0 gap-5 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="grid size-14 place-items-center rounded-2xl bg-sky-50 text-[#4f91b7]">
                <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
            </span>
            <div><p class="text-sm font-semibold text-slate-500">Productos en catálogo</p><p class="mt-1 text-3xl font-black text-slate-900">{{ $productosCount }}</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <span class="grid size-14 place-items-center rounded-2xl bg-violet-50 text-violet-600">
                <svg class="size-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linejoin="round" d="M5 3h14v18H5zM8 7h8m-8 4h8m-8 4h5"/></svg>
            </span>
            <div><p class="text-sm font-semibold text-slate-500">Órdenes recibidas</p><p class="mt-1 text-3xl font-black text-slate-900">{{ $ordenesCount }}</p></div>
        </div>
    </div>
    <section id="orders" class="mt-9 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-7">
        <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
            <div><p class="text-xs font-bold uppercase tracking-[0.15em] text-[#4f91b7]">Actividad de la tienda</p><h2 class="mt-1 text-xl font-black">Órdenes recientes</h2></div>
            <span class="rounded-full bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-500">{{ $ordenesCount }} en total</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-left">
                <thead class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-400"><tr><th class="px-4 py-3">Orden</th><th class="px-4 py-3">Cliente</th><th class="px-4 py-3">Fecha</th><th class="px-4 py-3">Artículos</th><th class="px-4 py-3">Total</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($ordenes as $orden)
                        <tr class="transition hover:bg-slate-50"><td class="px-4 py-4 font-bold text-[#397ca2]">#{{ $orden->id }}</td><td class="px-4 py-4 font-semibold">{{ $orden->customer_name }}</td><td class="px-4 py-4 text-sm text-slate-500">{{ $orden->created_at->format('d/m/Y H:i') }}</td><td class="px-4 py-4">{{ $orden->items_count }}</td><td class="px-4 py-4 font-bold">{{ $orden->currency_symbol }} {{ number_format((float) $orden->total, 2) }}</td></tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-12 text-center text-slate-500"><svg class="mx-auto size-8 text-slate-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3h8l4 4v14H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path stroke-linecap="round" d="M14 3v5h5M9 13h6m-6 4h6"/></svg><p class="mt-2 font-semibold">Todavía no hay órdenes</p><p class="mt-1 text-sm">Las nuevas compras aparecerán aquí.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-5">{{ $ordenes->links() }}</div>
    </section>
@endsection
