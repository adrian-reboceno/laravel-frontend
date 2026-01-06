<?php

namespace App\Http\Middleware;

use App\Infrastructure\Http\ApiClient;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response; // ✅
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

final class EnsureApiToken
{
    public function handle(Request $request, Closure $next): SymfonyResponse
    {
        $token = session('api_token');

        if (!$token) {
            return $this->unauthorized($request);
        }

        /** @var Response $res */  // ✅ Intelephense ya reconoce status()
        $res = ApiClient::make($token)->get('/auth/me');

        if ($res->status() === 401) {
            session()->forget(['api_token', 'api_user']);

            return $this->unauthorized($request);
        }

        return $next($request);
    }

    private function unauthorized(Request $request): SymfonyResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return redirect()->route('login');
    }
}
