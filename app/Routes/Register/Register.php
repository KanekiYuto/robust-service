<?php

namespace App\Routes\Register;

/**
 * 注册器抽象类
 *
 * @author KanekiYuto
 */
abstract class Register
{

    /**
     * 路由名称
     *
     * @var string|null
     */
    protected string|null $name = null;

    /**
     * 中间件
     *
     * @var array
     */
    protected array $middleware = [];

    /**
     * 排除中间件
     *
     * @var array
     */
    protected array $withoutMiddleware = [];

    /**
     * 设置路由名称
     *
     * @param  string  $name
     * @return static
     */
    public function name(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * 设置路由中间件
     *
     * @param  array  $middleware
     * @return static
     */
    public function middleware(array $middleware): static
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * 设置排除路由中间件
     *
     * @param  array  $withoutMiddleware
     * @return static
     */
    public function withoutMiddleware(array $withoutMiddleware): static
    {
        $this->withoutMiddleware = $withoutMiddleware;

        return $this;
    }

}
