<?php

namespace App\Http\Controllers\Backstage\Admin;

use App\Http\Service\Backstage\Admin\LogService;
use App\Models\Traces\Admin\Log as TheTrace;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * 管理员日志控制器
 *
 * @author KanekiYuto
 */
class LogController
{

    /**
     * 分页查询管理员日志信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function paging(Request $request): JsonResponse
    {
        return PagingQuery::request(
            request: $request,
            class: LogService::class,
            orderBy: [
                TheTrace::ID,
                TheTrace::UPDATED_AT,
                TheTrace::CREATED_AT,
            ],
            queryRule: [
                'id' => ['nullable', 'integer'],
                'admin_id' => ['nullable', 'integer'],
                'api' => ['nullable', 'string'],
                'ipaddress' => ['nullable', 'string'],
                'updated_at' => ['nullable', 'string'],
                'created_at' => ['nullable', 'string'],
            ]
        )->export()->json();
    }

}
