<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        then: function () {
            Route::middleware('web')
                ->prefix('super_admin')
                ->group(base_path('routes/dashboard.php'));
        },
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle CSRF token mismatch (419 error) - session expired
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Your session has expired. Please refresh the page and try again.',
                    'expired' => true
                ], 419);
            }

            // For regular requests, redirect to login with message
            return redirect()->route('login')
                ->with('error', 'Your session has expired. Please login again.')
                ->withInput($request->except('password', '_token'));
        });
    })->create();
