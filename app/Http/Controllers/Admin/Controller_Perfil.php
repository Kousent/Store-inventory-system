<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class Controller_Perfil extends Controller
{
    public function edit(Request $request): View
    {
        return view('admin.profile.edit', ['usuario' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($request->user()->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ]);

        $usuario = $request->user();
        $usuario->name = $validated['name'];
        $usuario->email = $validated['email'];
        if (! empty($validated['password'])) {
            $usuario->password = $validated['password'];
        }
        $usuario->save();

        return back()->with('success', 'Perfil actualizado.');
    }
}
