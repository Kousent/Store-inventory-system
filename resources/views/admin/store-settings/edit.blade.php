@extends('layouts.admin')

@section('title', 'Identidad de tienda')

@section('content')
    <div class="mb-7">
        <p class="text-xs font-extrabold uppercase tracking-[0.17em] text-[#4f91b7]">Personalización</p>
        <h2 class="mt-1 text-3xl font-black tracking-tight">Identidad de tienda</h2>
        <p class="mt-2 text-sm text-slate-500">Actualiza el nombre, el logotipo y la imagen principal de tu catálogo público.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">
        <form method="POST" action="{{ route('admin.store-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="grid size-11 place-items-center rounded-xl bg-sky-50 text-[#4f91b7]">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V7l8-4v18m0-14h6v14M8 9v.01M8 12v.01M8 15v.01M16 11v.01M16 14v.01M16 17v.01"/></svg>
                    </span>
                    <div><h3 class="font-extrabold">Nombre y moneda</h3><p class="text-sm text-slate-500">Se mostrarán en la navegación y en todos los precios.</p></div>
                </div>
                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="block text-sm font-bold text-slate-700">Nombre de la tienda
                        <input name="store_name" value="{{ old('store_name', $configuracion->store_name) }}" maxlength="120" required class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 font-normal focus:border-sky-400 focus:bg-white">
                    </label>
                    <label class="block text-sm font-bold text-slate-700">Moneda de precios
                        <select name="currency_code" required class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 font-normal focus:border-sky-400 focus:bg-white">
                            <option value="PEN" @selected(old('currency_code', $configuracion->currency_code) === 'PEN')>Soles peruanos (S/)</option>
                            <option value="USD" @selected(old('currency_code', $configuracion->currency_code) === 'USD')>Dólares estadounidenses ($)</option>
                        </select>
                    </label>
                </div>
                <p class="mt-3 text-xs leading-5 text-slate-500">El símbolo seleccionado se utilizará en el catálogo, carrito, órdenes y panel. Los importes existentes no se convierten automáticamente.</p>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-6 flex items-center gap-3">
                    <span class="grid size-11 place-items-center rounded-xl bg-violet-50 text-violet-600">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/></svg>
                    </span>
                    <div><h3 class="font-extrabold">Logotipo y banner</h3><p class="text-sm text-slate-500">Imágenes propias para reconocer tu tienda.</p></div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-bold text-slate-700">Logotipo
                            <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-sm">
                        </label>
                        <p class="mt-2 text-xs leading-5 text-slate-500">JPG, PNG o WebP · máximo 2 MB · se adapta al encabezado.</p>
                        @if ($configuracion->logo_path)
                            <div class="mt-4 flex h-24 items-center justify-center rounded-xl border border-slate-200 bg-slate-50 p-3">
                                <img src="{{ Storage::disk('public')->url($configuracion->logo_path) }}" alt="Logotipo actual" class="max-h-full max-w-full object-contain">
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-700">Banner principal
                            <input type="file" name="banner" accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-50 p-2 text-sm">
                        </label>
                        <p class="mt-2 text-xs leading-5 text-slate-500">JPG, PNG o WebP · máximo 5 MB · recomendado horizontal.</p>
                        @if ($configuracion->banner_path)
                            <div class="mt-4 h-24 overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                <img src="{{ Storage::disk('public')->url($configuracion->banner_path) }}" alt="Banner actual" class="size-full object-cover">
                            </div>
                        @endif
                    </div>
                </div>
            </section>

            <div class="flex justify-end">
                <button class="inline-flex items-center gap-2 rounded-xl bg-[#226a91] px-6 py-3 font-bold text-white shadow-sm transition hover:bg-[#174e6d]">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9.5 17 19 7"/></svg>
                    Guardar identidad
                </button>
            </div>
        </form>

        <aside class="h-fit overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4">
                <h3 class="font-extrabold">Vista previa</h3>
                <p class="mt-1 text-xs text-slate-500">Así aparece tu marca en la tienda.</p>
            </div>
            <div class="p-5">
                <div class="flex items-center gap-3 rounded-xl bg-[#5c9ac1] p-4 text-white">
                    <span class="grid size-10 place-items-center overflow-hidden rounded-xl bg-white text-lg font-black text-[#397ca2]">
                        @if ($configuracion->logo_path)
                            <img src="{{ Storage::disk('public')->url($configuracion->logo_path) }}" alt="" class="size-full object-contain p-1">
                        @else
                            {{ mb_strtoupper(mb_substr($configuracion->store_name, 0, 1)) }}
                        @endif
                    </span>
                    <span class="truncate font-extrabold">{{ $configuracion->store_name }}</span>
                </div>
                <div class="relative mt-4 grid h-36 place-items-center overflow-hidden rounded-xl bg-gradient-to-r from-emerald-900 to-emerald-700 p-4 text-center text-white">
                    @if ($configuracion->banner_path)
                        <img src="{{ Storage::disk('public')->url($configuracion->banner_path) }}" alt="" class="absolute inset-0 size-full object-cover">
                    @endif
                    <span class="relative rounded-lg bg-white/95 px-4 py-2 text-xl font-black text-slate-900 shadow-md">{{ $configuracion->store_name }}</span>
                </div>
                <p class="mt-3 text-sm font-bold text-slate-700">Precios de ejemplo: {{ old('currency_code', $configuracion->currency_code) === 'PEN' ? 'S/' : '$' }} 12.50</p>
            </div>
        </aside>
    </div>
@endsection
