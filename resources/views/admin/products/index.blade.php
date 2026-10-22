@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div><p class="text-xs font-bold uppercase tracking-[0.16em] text-[#4f91b7]">Inventario</p><h2 class="mt-1 text-3xl font-black">Productos</h2><p class="mt-1 text-sm text-slate-500">Administra imágenes, precios y existencias.</p></div>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#12bcd2] px-5 py-3 font-extrabold text-slate-950 shadow-lg shadow-cyan-700/10 transition hover:-translate-y-0.5 hover:bg-[#00a9c3]">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M12 5v14m-7-7h14"/></svg>
            Nuevo producto
        </a>
    </div>
    <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 bg-white px-5 py-4">
            <p class="font-bold text-slate-800">Productos e inventario</p>
            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-bold text-[#397ca2]">{{ $productos->total() }} productos</span>
        </div>
        <div class="overflow-x-auto">
        <table class="w-full min-w-[700px] text-left">
            <thead class="bg-[#f1fbfc] text-[11px] font-extrabold uppercase tracking-wider text-slate-500"><tr><th class="px-5 py-4">Producto</th><th class="px-5 py-4">Categoría</th><th class="px-5 py-4">Precio venta</th><th class="px-5 py-4">Stock</th><th class="px-5 py-4">Estado</th><th class="px-5 py-4">Acciones</th></tr></thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($productos as $producto)
                    <tr class="transition hover:bg-slate-50/80">
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                <span class="grid size-11 shrink-0 place-items-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    @if ($producto->image)
                                        <img src="{{ Storage::disk('public')->url($producto->image) }}" alt="" class="size-full object-contain p-1">
                                    @else
                                        <svg class="size-5 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                                    @endif
                                </span>
                                <span class="font-bold text-slate-800">{{ $producto->name }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-500">{{ $producto->category ?: '—' }}</td>
                        <td class="px-5 py-4 font-semibold">{{ $storeSettings->currency_symbol }} {{ number_format((float) $producto->price, 2) }}</td>
                        <td class="px-5 py-4"><span @class(['rounded-full px-2.5 py-1 text-xs font-bold', 'bg-emerald-50 text-emerald-700' => $producto->stock > 5, 'bg-amber-50 text-amber-700' => $producto->stock > 0 && $producto->stock <= 5, 'bg-rose-50 text-rose-700' => $producto->stock === 0])>{{ $producto->stock }} unidades</span></td>
                        <td class="px-5 py-4"><span @class(['rounded-full px-2.5 py-1 text-xs font-bold', 'bg-emerald-50 text-emerald-700' => $producto->is_active, 'bg-slate-100 text-slate-500' => ! $producto->is_active])>{{ $producto->is_active ? 'Activo' : 'Inactivo' }}</span></td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('admin.products.edit', $producto) }}" class="font-semibold text-indigo-700 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('admin.products.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="font-semibold text-red-700 hover:underline">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-12 text-center text-slate-500"><p class="font-semibold">Aún no hay productos</p><p class="mt-1 text-sm">Agrega el primero para mostrarlo en tu tienda.</p></td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
    <div class="mt-4">{{ $productos->links() }}</div>
@endsection
