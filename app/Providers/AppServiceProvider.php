<?php

namespace App\Providers;

use App\Ability\Ability;
use App\Models\Models\PersonalAccessToken;
use App\Watchers\RequestWatcher;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;
use Kaneki\Diverse\Database\Schema\Builder;
use Laravel\Sanctum\Sanctum;

/**
 * 应用服务提供者
 *
 * @author KanekiYuto
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * 注册任何应用服务
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

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

        $this->app->bind('diverse.db.schema', Builder::class);
    }

}
