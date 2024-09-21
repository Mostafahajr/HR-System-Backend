<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check.privilege' => \App\Http\Middleware\CheckPrivilege::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (TokenExpiredException $e, $request) {
            return response()->json(['error' => 'Token has expired'], 401);
        });

        // Handle TokenInvalidException globally
        $exceptions->render(function (TokenInvalidException $e, $request) {
            return response()->json(['error' => 'Token is invalid'], 401);
        });

        // Handle JWTException globally
        $exceptions->render(function (JWTException $e, $request) {
            return response()->json(['error' => 'Token is absent or malformed'], 401);
        });
    })->create();