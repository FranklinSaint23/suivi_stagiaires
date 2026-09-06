<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->redirectTo(
            guests: '/login',
            users: function (Request $request) {
                $user = $request->user();
                if ($user) {
                    return match ($user->role) {
                        'admin'     => route('admin.dashboard'),
                        'encadrant' => route('encadrant.dashboard'),
                        'stagiaire' => route('stagiaire.dashboard'),
                        default     => route('login'),
                    };
                }
                return route('login');
            }
        );
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
