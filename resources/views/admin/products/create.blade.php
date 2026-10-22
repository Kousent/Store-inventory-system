@extends('layouts.admin')

@section('title', 'Crear producto')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-[#4f91b7]">Inventario · Nuevo registro</p>
            <h2 class="mt-1 text-3xl font-black tracking-tight text-slate-900">Crear producto</h2>
            <p class="mt-2 text-sm text-slate-500">Completa la información para publicar un producto en tu catálogo.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-sky-200 hover:bg-sky-50">
            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6M9 12h12"/></svg>
            Volver a productos
        </a>
    </div>
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="mt-7">
        @csrf
        @include('admin.products._form')
    </form>
@endsection
