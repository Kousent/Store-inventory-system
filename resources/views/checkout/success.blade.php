@extends('layouts.public')

@section('title', 'Compra confirmada')

@section('content')
    <div class="mx-auto max-w-2xl rounded-2xl border border-emerald-200 bg-white p-8 text-center shadow-sm">
        <div class="text-4xl text-emerald-600">✓</div>
        <h1 class="mt-4 text-3xl font-bold">¡Gracias por tu compra, {{ $orden->customer_name }}!</h1>
        <p class="mt-3 text-slate-600">Tu orden #{{ $orden->id }} fue registrada correctamente.</p>
        <p class="mt-4 text-xl font-bold text-indigo-700">Total: {{ $orden->currency_symbol }} {{ number_format((float) $orden->total, 2) }}</p>
        <a href="{{ route('home') }}" class="mt-6 inline-block rounded-lg bg-indigo-600 px-5 py-3 font-semibold text-white hover:bg-indigo-700">Volver al catálogo</a>
    </div>
@endsection
