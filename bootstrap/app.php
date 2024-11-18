<?php


use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\Authenticate as AuthenticateMiddleware;
use App\Http\Middleware\BackstageAbility as BackstageAbilityMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function (){
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::prefix('backstage')
                ->name('backstage')
                ->group(base_path('routes/backstage.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'backstage.ability' => BackstageAbilityMiddleware::class,
            'auth' => AuthenticateMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
