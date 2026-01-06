<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Lang\LanguageController;
use App\Http\Controllers\Permision\PermissionsController;
use App\Http\Controllers\Public\IndexController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', [IndexController::class, 'index'])->name('public.index');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/password/update', [PasswordController::class, 'edit'])->name('password.edit');
Route::post('/password/update', [PasswordController::class, 'update'])->name('password.update');

Route::middleware('api.auth', 'nocache')
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
Route::middleware(['api.auth', 'nocache'])->group(function () {
    Route::get('/permissions', [PermissionsController::class, 'index'])->name('permissions.index');    
    Route::post('/ui/permissions/datatables', [PermissionsController::class, 'datatable'])->name('permissions.datatable');
    Route::get('/permissions/{id}/show', [PermissionsController::class, 'show'])->name('permissions.show');   

});

Route::get('/lang/{locale}', [LanguageController::class, 'set'])->name('lang.set');
