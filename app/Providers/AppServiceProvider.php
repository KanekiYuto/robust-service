<?php

namespace App\Providers;

use App\Ability\Ability;
use Laravel\Sanctum\Sanctum;
use App\Watchers\RequestWatcher;
use Illuminate\Support\ServiceProvider;
use App\Models\Models\PersonalAccessToken;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * 应用服务提供者
 *
 * @author KanekiYuto
 */
class AppServiceProvider extends ServiceProvider
{

	/**
	 * 引导任何应用程序服务
	 *
	 * @return void
	 * @throws BindingResolutionException
	 */
	public function boot(): void
	{
		$watcher = $this->app->make(RequestWatcher::class);
		$watcher->register($this->app);

		Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
		Ability::use();
	}

	/**
	 * 注册任何应用服务
	 *
	 * @return void
	 */
	public function register(): void
	{
		//
	}

}
