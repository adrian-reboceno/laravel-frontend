<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\EnsureApiToken;
use App\Http\Middleware\NoCache;
use App\Http\Middleware\SetLocaleFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // ✅ Aplica el idioma desde session('lang') en TODO el sitio
        $middleware->web(append: [
            SetLocaleFromSession::class,
        ]);

        // ✅ Aliases para rutas protegidas / no-cache
        $middleware->alias([
            'api.auth' => EnsureApiToken::class,
            'nocache'  => NoCache::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();
