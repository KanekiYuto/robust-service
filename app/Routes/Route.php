<?php

namespace App\Routes;

use Closure;
use App\Routes\Register\RouteRegister;
use App\Routes\Register\GroupRegister;

/**
 * 路由注册器
 *
 * @author KanekiYuto
 */
class Route
{

	/**
	 * [GET] 请求方法
	 *
	 * @var string
	 */
	const METHOD_GET = 'get';

	/**
	 * [POST] - 请求方法
	 *
	 * @var string
	 */
	const METHOD_POST = 'post';

	/**
	 * [GET] - 路由
	 *
	 * @param  string       $uri
	 * @param  string|null  $action
	 *
	 * @return RouteRegister
	 */
	public static function get(
		string $uri,
		string|null $action = null
	): RouteRegister {
		return new RouteRegister(
			self::METHOD_GET,
			$uri,
			empty($action) ? $uri : $action
		);
	}

	/**
	 * [POST] - 路由
	 *
	 * @param  string       $uri
	 * @param  string|null  $action
	 *
	 * @return RouteRegister
	 */
	public static function post(
		string $uri,
		string|null $action = null
	): RouteRegister {
		return new RouteRegister(
			self::METHOD_POST,
			$uri,
			empty($action) ? $uri : $action
		);
	}

	/**
	 * 路由组
	 *
	 * @param  Closure  $closure
	 *
	 * @return GroupRegister
	 */
	public static function group(
		Closure $closure
	): GroupRegister {
		return new GroupRegister($closure);
	}

	/**
	 * 根据路由名称取得路由类型
	 *
	 * @param  string  $route
	 *
	 * @return string
	 */
	public static function routeType(string $route): string
	{
		$route = explode(':', $route);
		return $route[1];
	}

}
