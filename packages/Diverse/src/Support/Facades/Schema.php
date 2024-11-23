<?php

namespace Kaneki\Diverse\Support\Facades;

use Closure;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void create(string $table, Closure $callback, string $comment = '')
 */
class Schema extends Facade
{

    /**
     * 指示是否应缓存已解析的 Facade
     *
     * @var bool
     */
    protected static $cached = false;

    /**
     * 获取组件的注册名称
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'diverse.db.schema';
    }

}
