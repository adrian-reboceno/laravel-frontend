<?php

namespace App\Services\Permisions;

use App\Infrastructure\Http\ApiClient;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class PermissionsDatatableService
{
    public function handle(Request $request, ?string $token): JsonResponse
    {
        $draw   = (int) $request->input('draw', 1);
        $start  = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 10);

        if ($length < 1) {
            $length = 10;
        }

        if ($length > 100) {
            $length = 100;
        }

        // DataTables search -> filtro name (API)
        $name = trim((string) $request->input('search.value', ''));

        // start/length => page/per_page
        $page = (int) floor($start / $length) + 1;

        /** @var Response $res */
        $res = ApiClient::make($token)->get('/permissions', [
            'page' => $page,
            'per_page' => $length,
            'name' => $name !== '' ? $name : null,
        ]);

        if ($res->status() === 401) {
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Unauthorized',
            ], 401);
        }

        if (! $res->ok()) {
            return response()->json([
                'draw' => $draw,
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => $res->json('message') ?? 'Error',
            ], 500);
        }

        $items = $res->json('data.data') ?? [];
        $meta  = $res->json('data.meta') ?? ['total' => 0];

        $total = (int) ($meta['total'] ?? 0);

        $data = array_map(static function (array $p): array {
            return [
                'id' => $p['id'] ?? null,
                'name' => $p['name'] ?? '',
                'guard_name' => $p['guard_name'] ?? '',
            ];
        }, $items);

        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ]);
    }
}
