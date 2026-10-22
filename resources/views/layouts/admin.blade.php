<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#226a91">
    <title>@yield('title', 'Administración') | {{ $storeSettings->store_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f1f7f8] text-slate-900 antialiased">
    <div data-admin-overlay class="fixed inset-0 z-40 hidden bg-slate-950/50 lg:hidden"></div>
    <aside data-admin-sidebar class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col bg-gradient-to-b from-[#139ed0] via-[#277cc5] to-[#6244aa] text-white shadow-2xl transition-transform duration-300 lg:translate-x-0">
        <div class="flex items-center gap-3 border-b border-white/15 px-6 py-6">
            <span class="grid size-12 place-items-center overflow-hidden rounded-2xl border border-white/30 bg-white/15 text-xl font-black shadow-inner">
                @if ($storeSettings->logo_path)
                    <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full bg-white object-contain p-1">
                @else
                    <span>{{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}</span>
                @endif
            </span>
            <div class="min-w-0">
                <p class="truncate font-extrabold">{{ $storeSettings->store_name }}</p>
                <p class="mt-0.5 text-xs text-white/70">Administración de tienda</p>
            </div>
            <button type="button" data-close-admin-sidebar class="ml-auto rounded-lg p-2 text-white/80 hover:bg-white/15 lg:hidden" aria-label="Cerrar menú">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-6">
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white/55">General</p>
                <a href="{{ route('admin.dashboard') }}" @class(['flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-white/20 text-white shadow-inner ring-1 ring-white/15' => request()->routeIs('admin.dashboard'), 'text-white/85 hover:bg-white/10' => ! request()->routeIs('admin.dashboard')])>
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                    Dashboard
                </a>
            </div>
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white/55">Tienda</p>
                <a href="{{ route('admin.products.index') }}" @class(['flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-white/20 text-white shadow-inner ring-1 ring-white/15' => request()->routeIs('admin.products.*'), 'text-white/85 hover:bg-white/10' => ! request()->routeIs('admin.products.*')])>
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                    Productos e inventario
                </a>
                <a href="{{ route('admin.dashboard') }}#orders" class="mt-1 flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold text-white/85 transition hover:bg-white/10">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linejoin="round" d="M5 3h14v18H5zM8 7h8m-8 4h8m-8 4h5"/></svg>
                    Órdenes de compra
                </a>
            </div>
            <div>
                <p class="px-3 pb-2 text-[10px] font-extrabold uppercase tracking-[0.2em] text-white/55">Cuenta</p>
                <a href="{{ route('admin.store-settings.edit') }}" @class(['flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-white/20 text-white shadow-inner ring-1 ring-white/15' => request()->routeIs('admin.store-settings.*'), 'text-white/85 hover:bg-white/10' => ! request()->routeIs('admin.store-settings.*')])>
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M3 12h2m14 0h2M5.64 5.64l1.42 1.42m9.88 9.88 1.42 1.42m0-12.72-1.42 1.42m-9.88 9.88-1.42 1.42"/><circle cx="12" cy="12" r="4"/></svg>
                    Identidad de tienda
                </a>
                <a href="{{ route('admin.profile.edit') }}" @class(['flex items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold transition', 'bg-white/20 text-white shadow-inner ring-1 ring-white/15' => request()->routeIs('admin.profile.*'), 'text-white/85 hover:bg-white/10' => ! request()->routeIs('admin.profile.*')])>
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path stroke-linecap="round" d="M4 21a8 8 0 0 1 16 0"/></svg>
                    Mi perfil
                </a>
            </div>
        </nav>
        <div class="border-t border-white/15 p-4">
            <div class="mb-3 flex items-center gap-3 rounded-xl bg-white/10 p-3">
                <span class="grid size-10 shrink-0 place-items-center rounded-full bg-white/20 font-bold">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                <div class="min-w-0">
                    <p class="truncate text-sm font-bold">{{ auth()->user()->name }}</p>
                    <p class="truncate text-xs text-white/65">Administrador</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-sm font-bold text-white/85 transition hover:bg-white/10">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10 17l5-5-5-5m5 5H3m9-9h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/></svg>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>
    <div class="min-h-screen min-w-0 lg:ml-72">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
            <div class="flex h-16 items-center justify-between px-5 sm:px-8">
                <div class="flex items-center gap-3">
                    <button type="button" data-toggle-admin-sidebar aria-label="Abrir menú" class="grid size-10 place-items-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 lg:hidden">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold text-slate-400">Panel de administración</p>
                        <h1 class="text-sm font-extrabold text-slate-800 sm:text-base">@yield('title', 'Inicio')</h1>
                    </div>
                </div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-xl bg-sky-50 px-3 py-2 text-xs font-bold text-sky-800 transition hover:bg-sky-100 sm:text-sm">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7M5 9v11h14V9m-9 11v-6h4v6"/></svg>
                    Ver tienda
                </a>
            </div>
        </header>
        <main class="mx-auto w-full min-w-0 max-w-[1500px] px-5 py-7 sm:px-8 sm:py-9">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</body>
</html>
