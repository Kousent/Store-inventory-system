@extends('layouts.public')

@section('title', 'Finalizar compra')

@section('content')
    <div class="mx-auto max-w-3xl">
        <div class="mb-6">
            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#4f91b7]">Ya casi terminamos</p>
            <h1 class="mt-1 text-3xl font-black">Datos de envío y pago</h1>
            <p class="mt-2 text-slate-500">Completa tus datos para confirmar el pedido.</p>
        </div>
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            @csrf
            <label class="block text-sm font-medium">Nombre completo
                <input name="customer_name" value="{{ old('customer_name') }}" required maxlength="255" autocomplete="name" class="mt-1 block w-full rounded-lg border-slate-300">
            </label>
            <label class="block text-sm font-medium">Correo electrónico
                <input type="email" name="email" value="{{ old('email') }}" required maxlength="255" autocomplete="email" class="mt-1 block w-full rounded-lg border-slate-300">
            </label>
            <label class="block text-sm font-medium">Teléfono
                <input type="tel" name="phone" value="{{ old('phone') }}" required maxlength="40" autocomplete="tel" class="mt-1 block w-full rounded-lg border-slate-300">
            </label>
            <label class="block text-sm font-medium">Dirección de envío
                <textarea name="shipping_address" required maxlength="2000" autocomplete="street-address" rows="3" class="mt-1 block w-full rounded-lg border-slate-300">{{ old('shipping_address') }}</textarea>
            </label>
            <label class="block text-sm font-medium">Método de pago
                <select name="payment_method" required class="mt-1 block w-full rounded-lg border-slate-300">
                    <option value="">Selecciona una opción</option>
                    <option value="cash_on_delivery" @selected(old('payment_method') === 'cash_on_delivery')>Efectivo contra entrega</option>
                    <option value="bank_transfer" @selected(old('payment_method') === 'bank_transfer')>Transferencia bancaria</option>
                    <option value="card_on_delivery" @selected(old('payment_method') === 'card_on_delivery')>Tarjeta contra entrega</option>
                </select>
            </label>
            <button class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#5c9ac1] px-5 py-3.5 font-extrabold text-white shadow-lg shadow-sky-900/15 transition hover:bg-[#397ca2]">Confirmar compra</button>
        </form>
    </div>
@endsection
