<?php

namespace App\Http\Controllers\Backstage;

use App\Ability\Ability;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use App\Cascade\Models\Admin\InfoModel;
use KanekiYuto\Handy\Support\Facades\Preacher;

/**
 * 能力控制器
 *
 * @author KanekiYuto
 */
class AbilityController
{

	/**
	 * 获取所有能力信息
	 *
	 * @param  Request  $request
	 *
	 * @return JsonResponse
	 */
	public function abilities(Request $request): JsonResponse
	{
		$requestParams = $request::validate([
			'rely' => ['required', 'string'],
		]);

		InfoModel::query()->create();

		return Preacher::rows(
			Ability::abilities($requestParams['rely'])
		)->export()->json();
	}

	/**
	 * 获取所有能力组信息
	 *
	 * @param  Request  $request
	 *
	 * @return JsonResponse
	 */
	public function groups(Request $request): JsonResponse
	{
		$requestParams = $request::validate([
			'rely' => ['nullable', 'string'],
		]);

		return Preacher::rows(
			Ability::groups($requestParams['rely'] ?? '')
		)->export()->json();
	}

}
