<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model_ConfiguracionTienda;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class Controller_ConfiguracionTienda extends Controller
{
    public function edit(): View
    {
        $configuracion = Model_ConfiguracionTienda::query()->findOrFail(1);

        return view('admin.store-settings.edit', compact('configuracion'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'store_name' => ['required', 'string', 'max:120'],
            'currency_code' => ['required', 'in:PEN,USD'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $configuracion = Model_ConfiguracionTienda::query()->findOrFail(1);
        $previousLogo = $configuracion->logo_path;
        $previousBanner = $configuracion->banner_path;
        $changes = [
            'store_name' => $validated['store_name'],
            'currency_code' => $validated['currency_code'],
        ];

        if ($request->hasFile('logo')) {
            $changes['logo_path'] = $this->storeImage($request, 'logo');
        }

        if ($request->hasFile('banner')) {
            $changes['banner_path'] = $this->storeImage($request, 'banner');
        }

        $configuracion->update($changes);

        if (isset($changes['logo_path']) && $previousLogo) {
            Storage::disk('public')->delete($previousLogo);
        }

        if (isset($changes['banner_path']) && $previousBanner) {
            Storage::disk('public')->delete($previousBanner);
        }

        return back()->with('success', 'La identidad de la tienda se actualizó correctamente.');
    }

    private function storeImage(Request $request, string $field): string
    {
        $path = $request->file($field)?->store('store', 'public');

        if (! $path) {
            throw new RuntimeException("No fue posible guardar el archivo {$field}.");
        }

        return $path;
    }
}
