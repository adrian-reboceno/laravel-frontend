<?php

namespace App\Http\Controllers\Lang;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class LanguageController
{
    public function set(Request $request, string $locale): RedirectResponse
    {
        $allowed = ['en','sp','de','it','ru','zh','fr','ar']; // ajusta si quieres más

        if (!in_array($locale, $allowed, true)) {
            return back();
        }

        $request->session()->put('lang', $locale);

        return back()->with('success', 'Idioma actualizado.');
    }
}
