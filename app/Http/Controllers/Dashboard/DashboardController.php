<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\ApiClient;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

final class DashboardController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $token = session('api_token');

        // Ajusta endpoint si tu backend usa otro
        /** @var Response $res */
        $res = ApiClient::make($token)->get('/auth/me');

        if ($res->status() === 401) {
            session()->forget('api_token');

            return redirect()
                ->route('login')
                ->with('error', 'Tu sesión expiró. Inicia sesión nuevamente.');
        }

        if (!$res->ok()) {
            return view('pages.dashboard.index', [
                'me' => null,
                'apiError' => $res->json('message') ?? 'No se pudo cargar el dashboard.',
            ]);
        }

        return view('pages.dashboard.index', [
            'me' => $res->json('data') ?? $res->json(),
            'apiError' => null,
        ]);
    }
}
