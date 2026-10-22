<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#426fc0">
    <title>Iniciar sesión | {{ $storeSettings->store_name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#edf7f6] font-sans text-slate-900 antialiased">
    <main class="grid min-h-screen lg:grid-cols-2">
        <section class="relative isolate flex min-h-[290px] flex-col overflow-hidden bg-gradient-to-br from-[#4c79ca] via-[#426fc0] to-[#315eaa] px-6 py-8 text-white sm:px-10 lg:min-h-screen lg:px-14 lg:py-12">
            <div aria-hidden="true" class="absolute -right-36 -top-40 -z-10 size-[28rem] rounded-full border-[54px] border-white/[0.06]"></div>
            <div aria-hidden="true" class="absolute -bottom-48 -left-40 -z-10 size-[30rem] rounded-full border-[58px] border-white/[0.06]"></div>

            <a href="{{ route('home') }}" class="inline-flex w-fit items-center gap-3 rounded-xl focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-4 focus-visible:ring-offset-[#426fc0]">
                <span class="grid size-12 place-items-center overflow-hidden rounded-2xl border border-white/25 bg-white/15 text-lg font-black shadow-inner">
                    @if ($storeSettings->logo_path)
                        <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full bg-white object-contain p-1">
                    @else
                        {{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}
                    @endif
                </span>
                <span>
                    <span class="block max-w-56 truncate text-sm font-extrabold tracking-wide">{{ $storeSettings->store_name }}</span>
                    <span class="mt-0.5 block text-xs text-blue-100">Tienda en línea</span>
                </span>
            </a>

            <div class="mx-auto flex w-full max-w-xl flex-1 flex-col justify-center py-8 lg:py-14">
                <div class="hidden size-24 place-items-center overflow-hidden rounded-full border-4 border-white/20 bg-white/10 text-4xl font-black shadow-2xl shadow-blue-950/20 sm:grid lg:size-28">
                    @if ($storeSettings->logo_path)
                        <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full bg-white object-contain p-2">
                    @else
                        {{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}
                    @endif
                </div>
                <p class="mt-5 text-xs font-extrabold uppercase tracking-[0.2em] text-blue-100">Administración de tienda</p>
                <h1 class="mt-3 text-3xl font-black leading-tight tracking-tight sm:text-4xl lg:text-5xl">{{ $storeSettings->store_name }}</h1>
                <p class="mt-4 max-w-lg text-sm leading-6 text-blue-50/90 sm:text-base sm:leading-7">Gestiona tu catálogo y revisa la actividad de tu tienda desde un solo lugar.</p>

                <ul class="mt-7 flex flex-wrap gap-2.5 text-xs font-bold text-cyan-50 sm:mt-9">
                    <li class="inline-flex items-center gap-2 rounded-full border border-cyan-200/25 bg-cyan-200/10 px-3.5 py-2.5">
                        <svg class="size-4 text-cyan-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linejoin="round" d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path stroke-linejoin="round" d="m4.5 7.8 7.5 4.3 7.5-4.3M12 21v-8.9"/></svg>
                        Productos
                    </li>
                    <li class="inline-flex items-center gap-2 rounded-full border border-cyan-200/25 bg-cyan-200/10 px-3.5 py-2.5">
                        <svg class="size-4 text-cyan-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linejoin="round" d="M5 3h14v18H5zM8 7h8m-8 4h8m-8 4h5"/></svg>
                        Órdenes
                    </li>
                    <li class="inline-flex items-center gap-2 rounded-full border border-cyan-200/25 bg-cyan-200/10 px-3.5 py-2.5">
                        <svg class="size-4 text-cyan-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2m0 14v2M3 12h2m14 0h2M5.64 5.64l1.42 1.42m9.88 9.88 1.42 1.42m0-12.72-1.42 1.42m-9.88 9.88-1.42 1.42"/><circle cx="12" cy="12" r="4"/></svg>
                        Identidad de tienda
                    </li>
                </ul>
            </div>

            <div class="hidden items-center gap-2 text-[11px] font-extrabold uppercase tracking-[0.14em] text-cyan-200/90 lg:flex">
                <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11Z"/><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/></svg>
                Acceso seguro al panel
            </div>
        </section>

        <section class="grid min-h-[calc(100vh-290px)] place-items-center px-5 py-10 sm:px-8 lg:min-h-screen lg:px-10">
            <div class="w-full max-w-md rounded-[1.75rem] border border-white bg-white p-6 shadow-[0_24px_70px_-28px_rgba(23,67,80,0.28)] sm:p-9">
                <div class="text-center">
                    <span class="mx-auto grid size-14 place-items-center overflow-hidden rounded-full border-2 border-cyan-100 bg-slate-50 text-lg font-black text-[#315eaa] shadow-[0_0_0_6px_rgba(6,182,212,0.06)]">
                        @if ($storeSettings->logo_path)
                            <img src="{{ Storage::disk('public')->url($storeSettings->logo_path) }}" alt="" class="size-full bg-white object-contain p-1">
                        @else
                            {{ mb_strtoupper(mb_substr($storeSettings->store_name, 0, 1)) }}
                        @endif
                    </span>
                    <h2 class="mt-5 text-2xl font-black tracking-tight text-slate-900">Iniciar sesión</h2>
                    <p class="mt-2 text-sm text-slate-500">Ingresa con tu cuenta para administrar la tienda.</p>
                </div>

                @if ($errors->any())
                    <div id="login-errors" role="alert" class="mt-6 flex gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
                        <svg class="mt-0.5 size-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M12 8v5m0 3h.01"/></svg>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="mt-7 space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="text-sm font-bold text-slate-700">Correo electrónico</label>
                        <div class="relative mt-2">
                            <svg class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8 6 8-6"/></svg>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" autofocus placeholder="usuario@tienda.com" @if ($errors->any()) aria-describedby="login-errors" @endif class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="text-sm font-bold text-slate-700">Contraseña</label>
                        <div class="relative mt-2">
                            <svg class="pointer-events-none absolute left-4 top-1/2 size-5 -translate-y-1/2 text-[#5c9ac1]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 10V7a4 4 0 1 1 8 0v3m-4 5v2"/></svg>
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña" @if ($errors->any()) aria-describedby="login-errors" @endif class="block w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-cyan-400 focus:bg-white focus:ring-4 focus:ring-cyan-100">
                        </div>
                    </div>
                    <label class="flex w-fit cursor-pointer items-center gap-2.5 text-sm text-slate-600">
                        <input type="checkbox" name="remember" value="1" @checked(old('remember')) class="size-4 rounded border-slate-300 text-cyan-600 focus:ring-cyan-500">
                        Recordarme en este dispositivo
                    </label>
                    <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-cyan-500 to-cyan-600 px-5 py-3.5 text-sm font-extrabold text-slate-950 shadow-lg shadow-cyan-500/20 transition hover:-translate-y-0.5 hover:from-cyan-400 hover:to-cyan-500 focus:outline-none focus-visible:ring-4 focus-visible:ring-cyan-200">
                        Ingresar al panel
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </button>
                </form>

                <div class="mt-7 border-t border-slate-100 pt-5 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-[#397ca2]">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12"/></svg>
                        Volver a la tienda
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
