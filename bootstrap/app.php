<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use KanekiYuto\Diverse\Preacher\Preacher;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use App\Http\Middleware\Authenticate as AuthenticateMiddleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Middleware\BackstageAbility as BackstageAbilityMiddleware;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))->withRouting(
	using: function () {
		Route::middleware('api')
			->prefix('api')
			->group(base_path('routes/api.php'));

		Route::prefix('backstage')
			->name('backstage')
			->group(base_path('routes/backstage.php'));
	},
	commands: __DIR__.'/../routes/console.php',
	health: '/up',
)->withMiddleware(function (Middleware $middleware) {
	$middleware->alias([
		'backstage.ability' => BackstageAbilityMiddleware::class,
		'auth' => AuthenticateMiddleware::class,
	]);
})->withExceptions(function (Exceptions $exceptions) {

	$exceptions->render(function (MethodNotAllowedHttpException $e) {
		return Preacher::msgCode(
			$e->getStatusCode(),
			'Method Not Allowed'
		)->export()->json();
	});

	$exceptions->render(function (NotFoundHttpException $e) {
		return Preacher::msgCode(
			$e->getStatusCode(),
			$e->getStatusCode().' Not Found'
		)->export()->json();
	});

	$exceptions->render(function (ValidationException $e) {
		return Preacher::msgCode(
			Preacher::RESP_CODE_WARN,
			$e->getMessage()
		)->export()->json();
	});

	$exceptions->render(function (Exception $e) {
		return Preacher::msgCode(
			Preacher::RESP_CODE_WARN,
			$e->getMessage()
		)->export()->json();
	});

})->create();
