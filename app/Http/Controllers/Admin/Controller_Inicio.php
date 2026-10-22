<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Model_Orden;
use App\Models\Model_Producto;
use Illuminate\Contracts\View\View;

class Controller_Inicio extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'productosCount' => Model_Producto::count(),
            'ordenesCount' => Model_Orden::count(),
            'ordenes' => Model_Orden::query()->latest()->withCount('items')->paginate(10),
        ]);
    }
}
