<?php

use App\Http\Middleware\IsAdminUser;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        IsAuthenticated::class;
        IsAdminUser::class;
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
