<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\ApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    //
    public function show(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        /** @var Response $res */
        $res = ApiClient::make()->post('/auth/login', $data);

        // Tu API (según lo que mostraste antes) devuelve data.access_token
        $token = $res->json('data.access_token');

        if (! $res->ok() || ! $token) {
            Log::warning('Login API failed', [
                'status' => $res->status(),
                'body' => $res->json(),
            ]);

            Alert::toast('Credenciales inválidas', 'error')
                ->position('top-end')
                ->autoClose(4000)
                ->timerProgressBar();

            return back()->onlyInput('email');
        }

        session(['api_token' => $token]);
        // ✅ Traer datos del usuario (me) y guardarlos en sesión
        /** @var Response $meRes */
        $meRes = ApiClient::make($token)->get('/auth/me');

        if ($meRes->ok()) {
            // Guardamos SOLO data (tu API regresa data.user, data.roles, data.permissions)
            session(['api_user' => $meRes->json('data')]);
        } else {
            Log::warning('Me API failed after login', [
                'status' => $meRes->status(),
                'body' => $meRes->json(),
            ]);
            // No bloqueamos el login; el topbar usará defaults.
        }

        alert()
            ->success('Bienvenido', 'Sesión iniciada correctamente.')
            ->showConfirmButton('Cerrar', '#3085d6')
            ->showCloseButton();

        // a donde lo mandas al loguear:
        return redirect()->route('dashboard'); // o route('dashboard') si tienes dashboard
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('api_token');
        $request->session()->forget('api_user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('public.index');
    }
}
