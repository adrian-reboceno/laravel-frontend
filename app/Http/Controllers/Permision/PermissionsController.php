<?php

namespace App\Http\Controllers\Permision;

use App\Http\Controllers\Controller;
use App\Infrastructure\Http\ApiClient;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use RealRashid\SweetAlert\Facades\Alert;
use App\Services\Permisions\PermissionsDatatableService;

final class PermissionsController extends Controller
{
    public function datatable(Request $request, PermissionsDatatableService $service): JsonResponse
    {
        return $service->handle($request, session('api_token'));
    }
    public function index(): View|RedirectResponse
    {
        return view('pages.permision.permissions.index');
    }
    public function show(int $id){
        return view('pages.permision.permissions.show');
    }
}
