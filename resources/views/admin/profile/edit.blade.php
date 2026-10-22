@extends('layouts.admin')

@section('title', 'Mi perfil')

@section('content')
    <div class="mb-7">
        <p class="text-xs font-extrabold uppercase tracking-[0.17em] text-[#4f91b7]">Cuenta y seguridad</p>
        <h2 class="mt-1 text-3xl font-black tracking-tight">Mi perfil</h2>
        <p class="mt-2 text-sm text-slate-500">Administra tus datos de acceso y mantén tu cuenta actualizada.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-[320px_1fr]">
        <aside class="h-fit overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="h-24 bg-gradient-to-r from-[#119fce] via-[#347fc1] to-[#6850b0]"></div>
            <div class="-mt-10 px-6 pb-6">
                <span class="grid size-20 place-items-center rounded-2xl border-4 border-white bg-[#eff8fb] text-2xl font-black text-[#397ca2] shadow-sm">{{ mb_strtoupper(mb_substr($usuario->name, 0, 1)) }}</span>
                <h3 class="mt-4 text-xl font-black text-slate-900">{{ $usuario->name }}</h3>
                <p class="mt-1 break-all text-sm text-slate-500">{{ $usuario->email }}</p>
                <span class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-bold text-emerald-700">
                    <span class="size-2 rounded-full bg-emerald-500"></span>
                    Administrador activo
                </span>
                <div class="mt-6 border-t border-slate-100 pt-5">
                    <p class="text-xs font-bold uppercase tracking-wide text-slate-400">Miembro desde</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700">{{ $usuario->created_at->translatedFormat('F Y') }}</p>
                </div>
            </div>
        </aside>

        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex items-center gap-3 border-b border-slate-100 pb-5">
                <span class="grid size-11 place-items-center rounded-xl bg-sky-50 text-[#4f91b7]">
                    <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M5 20a7 7 0 0 1 14 0"/></svg>
                </span>
                <div>
                    <h3 class="font-extrabold text-slate-900">Información personal</h3>
                    <p class="text-sm text-slate-500">Estos datos identifican tu cuenta administrativa.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div class="grid gap-5 sm:grid-cols-2">
                    <label class="block text-sm font-bold text-slate-700">Nombre completo
                        <input name="name" value="{{ old('name', $usuario->name) }}" required maxlength="255" autocomplete="name" class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 font-normal focus:border-sky-400 focus:bg-white">
                    </label>
                    <label class="block text-sm font-bold text-slate-700">Correo electrónico
                        <input type="email" name="email" value="{{ old('email', $usuario->email) }}" required autocomplete="email" class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 font-normal focus:border-sky-400 focus:bg-white">
                    </label>
                </div>

                <div class="rounded-2xl border border-sky-100 bg-sky-50/60 p-5">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="grid size-10 place-items-center rounded-xl bg-white text-[#4f91b7] shadow-sm">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="4" y="10" width="16" height="11" rx="2"/><path stroke-linecap="round" d="M8 10V7a4 4 0 1 1 8 0v3m-4 5v2"/></svg>
                        </span>
                        <div><h4 class="text-sm font-extrabold text-slate-800">Cambiar contraseña</h4><p class="text-xs text-slate-500">Déjalo en blanco si no deseas cambiarla.</p></div>
                    </div>
                    <div class="grid gap-5 sm:grid-cols-2">
                        <label class="block text-sm font-bold text-slate-700">Nueva contraseña
                            <input type="password" name="password" autocomplete="new-password" minlength="8" class="mt-2 block w-full rounded-xl border-slate-200 bg-white px-4 py-3 font-normal focus:border-sky-400">
                        </label>
                        <label class="block text-sm font-bold text-slate-700">Confirmar contraseña
                            <input type="password" name="password_confirmation" autocomplete="new-password" minlength="8" class="mt-2 block w-full rounded-xl border-slate-200 bg-white px-4 py-3 font-normal focus:border-sky-400">
                        </label>
                    </div>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
                    <p class="text-xs text-slate-400">Tus cambios se guardan de forma segura.</p>
                    <button class="inline-flex items-center gap-2 rounded-xl bg-[#226a91] px-5 py-3 font-bold text-white shadow-sm transition hover:bg-[#174e6d]">
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9.5 17 19 7"/></svg>
                        Guardar cambios
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
