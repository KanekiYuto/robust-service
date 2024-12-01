<?php

namespace App\Watchers;

use App\Constants\BackstageConstant;
use Illuminate\Contracts\Foundation\Application;
use App\Cascade\Models\Admin\LogModel as AdminLog;
use Illuminate\Foundation\Http\Events\RequestHandled;
use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheTrace;

/**
 * 请求监视器
 *
 * @author beta
 */
class RequestWatcher extends Watcher
{

	/**
	 * Register the watcher.
	 *
	 * @param  Application  $app
	 *
	 * @return void
	 */
	public function register(Application $app): void
	{
		$app['events']->listen(RequestHandled::class, [$this, 'recordRequest']);
	}

	/**
	 * Record an incoming HTTP request.
	 *
	 * @param  RequestHandled  $event
	 *
	 * @return void
	 */
	public function recordRequest(RequestHandled $event): void
	{
		$request = $event->request;

		// 仅记录 [POST] 请求
		// 排除请求方法
		if ($request->method() !== 'POST') {
			return;
		}

		// 排除非 [Guard] 路由
		$admin = $request->user(BackstageConstant::GUARD);
		if (empty($admin)) {
			return;
		}

		$route = $request->route();
		$routeName = optional($route)->getName();
		if (empty($routeName)) {
			return;
		}

		$response = $event->response;

		$model = AdminLog::query();
		$model->create([
			TheTrace::ADMIN_ID => optional($admin)->id,
			TheTrace::API => $routeName,
			TheTrace::IPADDRESS => $request->ip(),
			TheTrace::PAYLOAD => $request->input(),
			TheTrace::HEADERS => $request->headers->all(),
			TheTrace::RESPONSE => json_decode($response->getContent(), true),
		])->save();
	}

}
