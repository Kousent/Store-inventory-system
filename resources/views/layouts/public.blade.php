<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#286b83">
    <title>@yield('title', $storeSettings->store_name) | {{ $storeSettings->store_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f2f7f7] text-slate-900 antialiased">
    <div class="bg-[#24586f] text-white/90">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-2 text-xs sm:px-8">
            <span class="flex items-center gap-2">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                Calidad y confianza, todos los días
            </span>
            <span class="hidden text-white/80 sm:inline">Compra fácil · Atención cercana</span>
        </div>
    </div>
    <header class="sticky top-0 z-30 border-b border-white/20 bg-[#5c9ac1] text-white shadow-lg shadow-sky-950/10">
        <nav class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-5 py-4 sm:px-8">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-3">
                <span class="grid size-11 place-items-center overflow-hidden rounded-2xl border border-white/40 bg-white/15 text-xl font-black shadow-inner">
                    @if ($storeSettings->logo_path)
                        <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full object-contain bg-white p-1">
                    @else
                        <span>{{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}</span>
                    @endif
                </span>
                <span>
                    <span class="block max-w-40 truncate text-base font-extrabold tracking-tight sm:max-w-56">{{ $storeSettings->store_name }}</span>
                    <span class="block text-xs text-sky-100">Catálogo en línea</span>
                </span>
            </a>
            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('home') }}" class="rounded-full bg-white px-5 py-2 text-sm font-bold text-[#397ca2] shadow-sm">Inicio</a>
                <a href="{{ route('home') }}" class="rounded-full px-4 py-2 text-sm font-semibold text-white/90 transition hover:bg-white/15">Catálogo</a>
            </div>
            <div class="flex shrink-0 items-center gap-2">
                @auth
                    <a href="{{ route('admin.dashboard') }}" aria-label="Ir al panel de administración" title="Mi cuenta" class="grid size-11 place-items-center rounded-2xl border border-white/30 bg-white/10 transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white">
                @else
                    <a href="{{ route('login') }}" aria-label="Iniciar sesión" title="Iniciar sesión" class="grid size-11 place-items-center rounded-2xl border border-white/30 bg-white/10 transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white">
                @endauth
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M14 4h4a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-4M10 16l4-4-4-4m4 4H3"/></svg>
                </a>
                <button type="button" data-open-cart aria-label="Abrir carrito, {{ $cartCount }} {{ $cartCount === 1 ? 'producto' : 'productos' }}" class="relative grid size-12 place-items-center rounded-2xl border border-white/30 bg-white/10 transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4h2l2.1 10.4a2 2 0 0 0 2 1.6h8.2a2 2 0 0 0 2-1.6L21 8H6"/><path stroke-linecap="round" d="M9 8h11"/><circle cx="10" cy="20" r="1.25"/><circle cx="18" cy="20" r="1.25"/></svg>
                    @if ($cartCount > 0)
                        <span class="absolute -right-1 -top-1 grid min-w-5 place-items-center rounded-full bg-rose-500 px-1.5 py-0.5 text-[10px] font-black leading-none text-white ring-2 ring-[#5c9ac1]">{{ $cartCount }}</span>
                    @endif
                </button>
            </div>
        </nav>
    </header>
    <main class="mx-auto min-h-[65vh] max-w-7xl px-5 py-8 sm:px-8 sm:py-10">
        @include('partials.flash')
        @yield('content')
    </main>
    <footer class="mt-14 bg-[#101a24] text-slate-300">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-12 sm:px-8 md:grid-cols-[1.3fr_0.8fr_0.9fr]">
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="grid size-11 place-items-center overflow-hidden rounded-xl bg-white text-lg font-black text-slate-800">
                        @if ($storeSettings->logo_path)
                            <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full object-contain p-1">
                        @else
                            {{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}
                        @endif
                    </span>
                    <span class="font-extrabold text-white">{{ $storeSettings->store_name }}</span>
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-400">Una forma sencilla y confiable de encontrar lo que necesitas. Explora el catálogo y prepara tu pedido en línea.</p>
            </div>
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-[0.16em] text-white">Navegación</h2>
                <ul class="mt-4 space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="transition hover:text-white">Inicio</a></li>
                    <li><a href="{{ route('home') }}#productos" class="transition hover:text-white">Catálogo</a></li>
                    <li><a href="{{ route('carrito.index') }}" class="transition hover:text-white">Mi pedido</a></li>
                </ul>
            </div>
            <div>
                <h2 class="text-xs font-extrabold uppercase tracking-[0.16em] text-white">Atención</h2>
                <div class="mt-4 space-y-4 text-sm text-slate-400">
                    <p class="flex items-start gap-3">
                        <svg class="mt-0.5 size-5 shrink-0 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-4.4 7-11a7 7 0 1 0-14 0c0 6.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.2"/></svg>
                        <span>Realiza tu pedido desde el catálogo y completa tus datos de envío al confirmar.</span>
                    </p>
                    <p class="flex items-start gap-3">
                        <svg class="mt-0.5 size-5 shrink-0 text-sky-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2"/></svg>
                        <span>El método y los detalles de pago se confirman durante el checkout.</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="border-t border-white/10">
            <div class="mx-auto flex max-w-7xl flex-col justify-between gap-2 px-5 py-5 text-xs text-slate-500 sm:flex-row sm:px-8">
                <span>© {{ now()->year }} {{ $storeSettings->store_name }}. Todos los derechos reservados.</span>
                <span>Compra fácil · Atención cercana</span>
            </div>
        </div>
    </footer>
    @include('partials.cart-drawer')
</body>
</html>
