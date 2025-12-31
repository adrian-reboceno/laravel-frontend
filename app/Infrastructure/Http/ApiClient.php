<?php

namespace App\Infrastructure\Http;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

final class ApiClient
{
    public static function make(?string $token = null): PendingRequest
    {
        $req = Http::baseUrl(config('api.base_url'))
            ->timeout(config('api.timeout'))
            ->acceptJson();

        return $token ? $req->withToken($token) : $req;
    }
}