<?php

namespace App\Http\Controllers\Backstage;

use App\Ability\Ability;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use KanekiYuto\Diverse\Preacher\Preacher;

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
     * @return JsonResponse
     */
    public function abilities(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'rely' => ['required', 'string'],
        ]);

        return Preacher::rows(
            Ability::abilities($requestParams['rely'])
        )->export()->json();
    }

    /**
     * 获取所有能力组信息
     *
     * @param  Request  $request
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
