<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\IndexController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Lang\LanguageController;


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

Route::get('/lang/{locale}', [LanguageController::class, 'set'])->name('lang.set');