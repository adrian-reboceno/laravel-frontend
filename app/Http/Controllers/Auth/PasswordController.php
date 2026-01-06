<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PasswordController extends Controller
{
    //
    /**
     * Formulario para actualizar contraseña (público)
     * Ej: llega con token y email por query: /password/update?token=XXX&email=...
     */
    public function edit(Request $request): View
    {
        return view('auth.passwords.email');
    }

    /**
     * password.update (POST)
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Ajusta el endpoint a tu API real:

    }
}
