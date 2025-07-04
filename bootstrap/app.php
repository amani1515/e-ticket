<?php

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
        // Register security middleware
        $middleware->alias([
            'prevent.caching' => \App\Http\Middleware\PreventCaching::class,
            'security.headers' => \App\Http\Middleware\SecurityHeaders::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class, // <-- Add this line

        ]);
        
        // Apply security headers globally
        $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
