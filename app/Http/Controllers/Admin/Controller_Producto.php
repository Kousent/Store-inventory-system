<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model_Producto;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Controller_Producto extends Controller
{
    public function index(): View
    {
        $productos = Model_Producto::query()->latest()->paginate(15);

        return view('admin.products.index', compact('productos'));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'producto' => new Model_Producto,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');

        Model_Producto::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto creado.');
    }

    public function edit(Model_Producto $producto): View
    {
        return view('admin.products.edit', compact('producto'));
    }

    public function update(Request $request, Model_Producto $producto): RedirectResponse
    {
        $data = $this->validatedData($request);
        if ($request->hasFile('image')) {
            if ($producto->image) {
                Storage::disk('public')->delete($producto->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');

        $producto->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Model_Producto $producto): RedirectResponse
    {
        if ($producto->image) {
            Storage::disk('public')->delete($producto->image);
        }
        $producto->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }

    /** @return array{name: string, description: string, category: ?string, price: string, stock: int, image?: UploadedFile} */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'category' => ['nullable', 'string', 'max:120'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'stock' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}
