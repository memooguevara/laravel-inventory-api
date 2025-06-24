<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Support\Facades\Route;

// PUBLIC ROUTES
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// PROTECTED ROUTES
Route::middleware([IsAuthenticated::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
    });
});
