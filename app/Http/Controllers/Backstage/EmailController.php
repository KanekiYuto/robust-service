<?php

namespace App\Http\Controllers\Backstage;

use App\Http\Service\Backstage\EmailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

/**
 * 邮箱控制器
 *
 * @author KanekiYuto
 */
class EmailController
{

    /**
     * 发生邮件
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function send(Request $request): JsonResponse
    {
        $typeRule = ['backstage-admin-modify-email'];
        $requestParams = $request::validate([
            'type' => ['required', 'string', Rule::in($typeRule)],
        ]);

        return EmailService::send(
            $request::user('admin')->email,
            $requestParams['type']
        )->export()->json();
    }

}
