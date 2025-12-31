<?php

namespace App\Providers;

use App\Support\ApiUserPresenter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

final class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Presenter como singleton
        $this->app->singleton(ApiUserPresenter::class);
    }

    public function boot(ApiUserPresenter $presenter): void
    {
        /**
         * Inyecta $apiUser SOLO en layouts.topbar
         * (resources/views/layouts/topbar.blade.php)
         */
        View::composer('layouts.topbar', function ($view) use ($presenter) {
            $data = session('api_user', []); // aquí guardas data del /auth/me
            $view->with('apiUser', $presenter->present($data));
        });
    }
}
