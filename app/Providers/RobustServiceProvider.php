<?php

namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Console\Migrations\MigrateCommand;
use Illuminate\Support\ServiceProvider;
use KanekiYuto\Robust\Cascades\Console\CascadeCommand;
use KanekiYuto\Robust\Database\Schema\Builder;
use KanekiYuto\Robust\Support\Facades\Schema;

/**
 * 服务提供者
 *
 * @author KanekiYuto
 */
class RobustServiceProvider extends ServiceProvider
{

    /**
     * 命令注册
     *
     * @var array
     */
    protected array $commands = [
        'Cascade' => CascadeCommand::class
    ];

    /**
     * 注册服务
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerCommands($this->commands);

        $this->app->bind(Schema::FACADE_ACCESSOR, Builder::class);
    }

    /**
     * 注册给定的命令
     *
     * @param array $commands
     * @return void
     */
    protected function registerCommands(array $commands): void
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }

    /**
     * 注册这个命令
     *
     * @return void
     */
    protected function registerCascadeCommand(): void
    {
        $this->app->singleton(CascadeCommand::class, function ($app) {
            return new CascadeCommand();
        });
    }

    /**
     * 引导服务
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

}
