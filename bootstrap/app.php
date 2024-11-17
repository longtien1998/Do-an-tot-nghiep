<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // health: '/up',
        health: '/status',


    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware -> alias([
            'admin' => \App\Http\Middleware\Authentication::class,
        ]);
        $middleware = [
            \Illuminate\Http\Middleware\HandleCors::class, // Middleware CORS
            // Các middleware khác...
        ];

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
