<?php

namespace App\Http\Controllers\Backstage\Admin;

use App\Http\Service\Backstage\Admin\RoleService;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

/**
 * 管理员角色控制器
 *
 * @author KanekiYuto
 */
class RoleController
{

    /**
     * 分页查询管理员角色信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function paging(Request $request): JsonResponse
    {
        return PagingQuery::request(
            request: $request,
            class: RoleService::class,
            orderBy: [
                TheTrace::ID,
                TheTrace::UPDATED_AT,
                TheTrace::CREATED_AT,
            ],
            queryRule: [
                'id' => ['nullable', 'string']
            ]
        )->export()->json();
    }

    /**
     * 管理员角色选项
     *
     * @return JsonResponse
     */
    public function select(): JsonResponse
    {
        return RoleService::select()->export()->json();
    }

    /**
     * 新增管理员角色信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function append(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'name' => ['required', 'string'],
            'explain' => ['nullable', 'string'],
        ]);

        return RoleService::append(
            $requestParams['name'],
            $requestParams['explain']
        )->export()->json();
    }

    /**
     * 修改管理员角色信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'explain' => ['nullable', 'string'],
        ]);

        return RoleService::modify(
            $requestParams['id'],
            $requestParams['name'],
            $requestParams['explain'] ?? ''
        )->export()->json();
    }

    public function delete(Request $request): void
    {
    }

    /**
     * 设置角色能力
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function ability(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'abilities' => ['array'],
        ]);

        return RoleService::ability(
            $requestParams['id'],
            $requestParams['abilities'],
        )->export()->json();
    }

}
