<?php

namespace App\Routes\Register;

use App\Routes\Route;
use Illuminate\Support\Facades\Route as RouteFacades;

/**
 * 路由注冊器
 *
 * @author KanekiYuto
 */
class RouteRegister extends Register
{

	/**
	 * 请求方法
	 *
	 * @var string
	 */
	private string $method;

	/**
	 * 请求 [URI]
	 *
	 * @var string
	 */
	private string $uri;

	/**
	 * 行为
	 *
	 * @var string
	 */
	private string $action;

	/**
	 * 构造函数
	 *
	 * @param  string  $method
	 * @param  string  $uri
	 * @param  string  $action
	 */
	public function __construct(
		string $method,
		string $uri,
		string $action
	) {
		$this->method = $method;
		$this->uri = $uri;
		$this->action = $action;
	}

	/**
	 * 完成时调用
	 *
	 * @return void
	 */
	public function finish(): void
	{
		// ...
	}

	/**
	 * 添加路由信息到组中
	 *
	 * @return void
	 */
	public function __destruct()
	{
		$this->name = empty($this->name) ? $this->uri : $this->name;
		$this->name = ':'.$this->name;

		$route = match ($this->method) {
			Route::METHOD_POST => RouteFacades::post($this->uri, $this->action),
			default => RouteFacades::get($this->uri, $this->action)
		};

		if (!empty($this->name)) {
			$route = $route->name($this->name);
		}

		$route = $route->middleware($this->middleware);
		$route->withoutMiddleware($this->withoutMiddleware);
	}

}
