<div class="grid gap-6 xl:grid-cols-[minmax(0,1.65fr)_minmax(280px,0.85fr)]">
    <div class="space-y-6">
        @if ($errors->any())
            <div role="alert" class="flex gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                <svg class="mt-0.5 size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v5m0 3h.01"/></svg>
                <div>
                    <p class="font-extrabold">Revisa la información del formulario</p>
                    <ul class="mt-1 list-inside list-disc space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                <span class="grid size-10 place-items-center rounded-xl bg-sky-50 text-[#397ca2]">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/></svg>
                </span>
                <div>
                    <h3 class="font-extrabold text-slate-900">Información del producto</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Describe claramente lo que verá el cliente.</p>
                </div>
            </div>

            <div class="space-y-5 p-5 sm:p-6">
                <div>
                    <label for="product-name" class="block text-sm font-bold text-slate-700">Nombre del producto <span class="text-rose-500">*</span></label>
                    <input id="product-name" data-product-name name="name" value="{{ old('name', $producto->name) }}" required maxlength="255" placeholder="Ej. Aceite vegetal 1 litro" @class(['mt-2 block w-full rounded-xl border bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:bg-white focus:ring-4 focus:ring-sky-100', 'border-rose-300 focus:border-rose-400' => $errors->has('name'), 'border-slate-200 focus:border-sky-400' => ! $errors->has('name')])>
                    @error('name')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="product-description" class="block text-sm font-bold text-slate-700">Descripción <span class="text-rose-500">*</span></label>
                    <textarea id="product-description" name="description" required maxlength="10000" rows="5" placeholder="Incluye detalles que ayuden a tus clientes a conocer mejor este producto." @class(['mt-2 block w-full resize-y rounded-xl border bg-slate-50 px-4 py-3 text-sm leading-6 text-slate-900 outline-none transition placeholder:text-slate-400 focus:bg-white focus:ring-4 focus:ring-sky-100', 'border-rose-300 focus:border-rose-400' => $errors->has('description'), 'border-slate-200 focus:border-sky-400' => ! $errors->has('description')])>{{ old('description', $producto->description) }}</textarea>
                    @error('description')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="product-category" class="block text-sm font-bold text-slate-700">Categoría <span class="font-normal text-slate-400">(opcional)</span></label>
                    <input id="product-category" name="category" value="{{ old('category', $producto->category) }}" maxlength="120" placeholder="Ej. Abarrotes, Bebidas o Limpieza" @class(['mt-2 block w-full rounded-xl border bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:bg-white focus:ring-4 focus:ring-sky-100', 'border-rose-300 focus:border-rose-400' => $errors->has('category'), 'border-slate-200 focus:border-sky-400' => ! $errors->has('category')])>
                    <p class="mt-1.5 text-xs text-slate-500">Los productos de una misma categoría aparecerán como relacionados.</p>
                    @error('category')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                <span class="grid size-10 place-items-center rounded-xl bg-emerald-50 text-emerald-700">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm4 8h6m-6 4h4"/></svg>
                </span>
                <div>
                    <h3 class="font-extrabold text-slate-900">Precio e inventario</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Controla el precio de venta y la disponibilidad.</p>
                </div>
            </div>

            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6">
                <div>
                    <label for="product-price" class="block text-sm font-bold text-slate-700">Precio ({{ $storeSettings->currency_symbol }}) <span class="text-rose-500">*</span></label>
                    <div class="relative mt-2">
                        <span class="pointer-events-none absolute inset-y-0 left-0 grid w-12 place-items-center rounded-l-xl border-r border-slate-200 bg-slate-100 text-sm font-extrabold text-slate-600">{{ $storeSettings->currency_symbol }}</span>
                        <input id="product-price" data-product-price type="number" name="price" value="{{ old('price', $producto->price) }}" min="0" max="99999999.99" step="0.01" required placeholder="0.00" @class(['block w-full rounded-xl border bg-slate-50 py-3 pl-16 pr-4 text-sm text-slate-900 outline-none transition focus:bg-white focus:ring-4 focus:ring-sky-100', 'border-rose-300 focus:border-rose-400' => $errors->has('price'), 'border-slate-200 focus:border-sky-400' => ! $errors->has('price')])>
                    </div>
                    @error('price')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="product-stock" class="block text-sm font-bold text-slate-700">Unidades en stock <span class="text-rose-500">*</span></label>
                    <input id="product-stock" data-product-stock type="number" name="stock" value="{{ old('stock', $producto->stock ?? 0) }}" min="0" step="1" required placeholder="0" @class(['mt-2 block w-full rounded-xl border bg-slate-50 px-4 py-3 text-sm text-slate-900 outline-none transition focus:bg-white focus:ring-4 focus:ring-sky-100', 'border-rose-300 focus:border-rose-400' => $errors->has('stock'), 'border-slate-200 focus:border-sky-400' => ! $errors->has('stock')])>
                    <p class="mt-1.5 text-xs text-slate-500">Usa 0 si el producto está agotado.</p>
                    @error('stock')
                        <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
                <span class="grid size-10 place-items-center rounded-xl bg-violet-50 text-violet-700">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path stroke-linecap="round" stroke-linejoin="round" d="m21 15-5-5L5 21"/></svg>
                </span>
                <div>
                    <h3 class="font-extrabold text-slate-900">Imagen del producto</h3>
                    <p class="mt-0.5 text-xs text-slate-500">Una buena imagen ayuda a destacar en el catálogo.</p>
                </div>
            </div>

            <div class="p-5 sm:p-6">
                <label for="product-image" class="group flex cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 px-5 py-7 text-center transition hover:border-sky-400 hover:bg-sky-50/60 focus-within:border-sky-400 focus-within:ring-4 focus-within:ring-sky-100">
                    <span class="grid size-12 place-items-center rounded-2xl bg-white text-[#4f91b7] shadow-sm transition group-hover:scale-105">
                        <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0L7 9m5-5 5 5"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 14v4a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-4"/></svg>
                    </span>
                    <span class="mt-3 text-sm font-extrabold text-slate-800">Selecciona una imagen</span>
                    <span data-image-file-name class="mt-1 max-w-full truncate text-xs text-slate-500">JPG, PNG o WebP · máximo 2 MB</span>
                    <input id="product-image" data-product-image type="file" name="image" accept="image/jpeg,image/png,image/webp" class="sr-only">
                </label>
                @error('image')
                    <p class="mt-2 text-xs font-semibold text-rose-600">{{ $message }}</p>
                @enderror
                @if ($producto->exists)
                    <p class="mt-2 text-xs text-slate-500">Si no seleccionas otra imagen, se conservará la actual.</p>
                @endif
            </div>
        </section>
    </div>

    <aside class="space-y-6">
        <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:sticky xl:top-24">
            <div class="border-b border-slate-100 px-5 py-4">
                <p class="text-xs font-extrabold uppercase tracking-[0.15em] text-[#4f91b7]">Vista previa</p>
                <h3 class="mt-1 font-extrabold text-slate-900">Así se verá tu producto</h3>
            </div>
            <div class="p-5">
                <div class="grid h-56 place-items-center overflow-hidden rounded-xl bg-slate-50 p-4">
                    <img data-product-image-preview @if (! $producto->image) hidden @endif src="{{ $producto->image ? Storage::disk('public')->url($producto->image) : '' }}" alt="{{ $producto->name ?: 'Vista previa del producto' }}" class="size-full object-contain">
                    <div data-product-image-placeholder @if ($producto->image) hidden @endif class="flex flex-col items-center text-slate-400">
                        <svg class="size-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                        <span class="mt-2 text-xs font-semibold">La imagen aparecerá aquí</span>
                    </div>
                </div>
                <div class="mt-4">
                    <p data-product-name-preview class="line-clamp-2 min-h-12 font-extrabold text-slate-900">{{ old('name', $producto->name) ?: 'Nombre del producto' }}</p>
                    <p data-product-category-preview class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-400">{{ old('category', $producto->category) ?: 'Categoría' }}</p>
                    <p class="mt-3 text-xl font-black text-[#397ca2]">{{ $storeSettings->currency_symbol }} <span data-product-price-preview>{{ old('price', $producto->price) ? number_format((float) old('price', $producto->price), 2) : '0.00' }}</span></p>
                    <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-4">
                        <span class="text-xs font-semibold text-slate-500">Disponibilidad</span>
                        <span data-product-stock-preview class="text-xs font-bold text-slate-700">{{ old('stock', $producto->stock ?? 0) }} unidades</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-2xl border border-sky-100 bg-sky-50/80 p-5">
            <div class="flex gap-3">
                <svg class="mt-0.5 size-5 shrink-0 text-[#397ca2]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 11v5m0-8h.01"/></svg>
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800">Consejo para tu catálogo</h3>
                    <p class="mt-1 text-xs leading-5 text-slate-600">Usa nombres claros, precios correctos y una imagen nítida. Asigna la misma categoría a productos similares para que aparezcan relacionados.</p>
                </div>
            </div>
        </section>
    </aside>

    <div class="flex flex-col-reverse gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:px-6 xl:col-span-2">
        <div class="flex items-center gap-3">
            <input id="product-active" type="checkbox" name="is_active" value="1" @checked(old('is_active', $producto->is_active ?? true)) class="size-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
            <label for="product-active" class="cursor-pointer">
                <span class="block text-sm font-bold text-slate-800">Producto activo</span>
                <span class="block text-xs text-slate-500">Visible para los clientes en el catálogo</span>
            </label>
        </div>
        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-600 transition hover:bg-slate-50">Cancelar</a>
            <button class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#12bcd2] px-6 py-3 text-sm font-extrabold text-slate-950 shadow-md shadow-cyan-700/10 transition hover:-translate-y-0.5 hover:bg-[#00a9c3] focus:outline-none focus-visible:ring-4 focus-visible:ring-cyan-200">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 12.5 4.5 4.5L19 7"/></svg>
                {{ $producto->exists ? 'Guardar cambios' : 'Crear producto' }}
            </button>
        </div>
    </div>
</div>
