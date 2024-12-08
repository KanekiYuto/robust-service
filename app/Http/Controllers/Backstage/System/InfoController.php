<?php

namespace App\Http\Controllers\Backstage\System;

use KanekiYuto\Handy\Support\Facades\Preacher;
use KanekiYuto\Handy\Preacher\PreacherResponse;

/**
 * 系統信息
 *
 * @author KanekiYuto
 */
class InfoController
{

	/**
	 * 基础信息
	 *
	 * @return PreacherResponse
	 */
	public function base(): PreacherResponse
	{
		return Preacher::rows([
			[
				'label' => 'Application name',
				'value' => config('app.name'),
			],
			[
				'label' => 'Application version',
				'value' => config('app.versions'),
			],
			[
				'label' => 'Cache driver',
				'value' => config('cache.default'),
			],
			[
				'label' => 'Session driver',
				'value' => config('session.driver'),
			],
			[
				'label' => 'Broadcasting driver',
				'value' => config('broadcasting.default'),
			],
		]);
	}

}
