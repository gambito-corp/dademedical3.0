<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function(Router $router){

            $router->middleware('web')
                ->group(base_path('routes/web.php'));

            $router->middleware(['api'])
                ->namespace('App\Http\Controllers')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            },
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        pages: __DIR__.'/../routes/pages.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
