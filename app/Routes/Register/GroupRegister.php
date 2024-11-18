<?php

namespace App\Routes\Register;

use Closure;
use Illuminate\Support\Facades\Route as RouteFacades;

/**
 * 路由组注册器
 *
 * @author KanekiYuto
 */
class GroupRegister extends Register
{

    /**
     * 回调函数
     *
     * @var Closure
     */
    private Closure $callback;

    /**
     * 控制器名称
     *
     * @var string|null
     */
    private string|null $controller = null;

    /**
     * [URI] 前缀
     *
     * @var string|null
     */
    private string|null $prefix = null;

    /**
     * 构造函数
     *
     * @param  Closure  $callback
     */
    public function __construct(
        Closure $callback
    ) {
        $this->callback = $callback;
    }

    /**
     * 设置控制器
     *
     * @param  string  $controller
     * @return static
     */
    public function controller(string $controller): static
    {
        $this->controller = $controller;

        return $this;
    }

    /**
     * 设置 [URI] 前缀
     *
     * @param  string  $prefix
     * @return static
     */
    public function prefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    /**
     * 设置 [URI] 前缀和路由名称
     *
     * @param  string  $prefix
     * @param  string|null  $name
     * @return static
     */
    public function prefixAndName(
        string $prefix,
        string|null $name = null
    ): static {
        $this->prefix = $prefix;
        $this->name = empty($name) ? $prefix : $name;

        return $this;
    }

    /**
     * 添加路由信息到组中
     *
     * @return void
     */
    public function __destruct()
    {
        if (!empty($this->name)) {
            $this->name = '.'.$this->name;
        }

        $callback = $this->callback;

        $route = RouteFacades::middleware($this->middleware);
        $route = $route->withoutMiddleware($this->withoutMiddleware);

        if (!empty($this->name)) {
            $route = $route->name($this->name);
        }

        if (!empty($this->prefix)) {
            $route = $route->prefix($this->prefix);
        }

        if (!empty($this->controller)) {
            $route = $route->controller($this->controller);
        }

        $route->group($callback);
    }

}
