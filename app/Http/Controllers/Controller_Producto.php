<?php

namespace App\Http\Controllers;

use App\Models\Model_Producto;
use Illuminate\Contracts\View\View;

class Controller_Producto extends Controller
{
    public function index(): View
    {
        $productos = Model_Producto::query()
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('store.index', compact('productos'));
    }

    public function show(Model_Producto $producto): View
    {
        abort_unless($producto->is_active, 404);

        $relacionados = Model_Producto::query()
            ->where('is_active', true)
            ->where('id', '!=', $producto->getKey())
            ->when(
                $producto->category,
                fn ($query) => $query->where('category', $producto->category)
            )
            ->latest()
            ->limit(4)
            ->get();

        if ($relacionados->isEmpty()) {
            $relacionados = Model_Producto::query()
                ->where('is_active', true)
                ->where('id', '!=', $producto->getKey())
                ->latest()
                ->limit(4)
                ->get();
        }

        $relacionadosPorCategoria = $producto->category !== null
            && $relacionados->first()?->category === $producto->category;

        return view('store.show', compact('producto', 'relacionados', 'relacionadosPorCategoria'));
    }
}
