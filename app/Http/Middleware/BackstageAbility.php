<?php

namespace App\Http\Middleware;

use Closure;
use App\Ability\Ability;
use Illuminate\Http\Request;
use KanekiYuto\Handy\Support\Facades\Preacher;
use KanekiYuto\Handy\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;

/**
 * 后台能力验证中间件
 *
 * @author KanekiYuto
 */
class BackstageAbility
{

	/**
	 * 处理传入的请求
	 *
	 * @param  Request  $request
	 * @param  Closure  $next
	 *
	 * @return mixed
	 */
	public function handle(Request $request, Closure $next): mixed
	{
		$user = $request->user('admin');
		$roleInfo = $user->role;
		$abilitiesField = TheTrace::ABILITIES;

		if (!Ability::apiRoute(
			$request->route()->getName(),
			$roleInfo->$abilitiesField,
		)) {
			return Preacher::msgCode(
				PreacherResponse::RESP_CODE_ACCESS_DENIED,
				'无权访问'
			)->export()->json();
		}

		return $next($request);
	}

}
