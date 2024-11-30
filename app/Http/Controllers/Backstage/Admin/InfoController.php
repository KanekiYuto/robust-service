<?php

namespace App\Http\Controllers\Backstage\Admin;

use App\Http\Service\Backstage\Admin\InfoService;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheTrace;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use KanekiYuto\Diverse\Preacher\Preacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rules\Password;

/**
 * 管理員信息控制器
 *
 * @author KanekiYuto
 */
class InfoController
{

    /**
     * 分頁查詢獲取管理員信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function paging(Request $request): JsonResponse
    {
        $orderBy = [
            TheTrace::ID,
            TheTrace::ACCOUNT,
            TheTrace::EMAIL,
            TheTrace::UPDATED_AT,
            TheTrace::CREATED_AT,
        ];

        return PagingQuery::request(
            request: $request,
            class: InfoService::class,
            orderBy: $orderBy,
            queryRule: [
                'id' => ['nullable', 'string']
            ]
        )->export()->json();
    }

    /**
     * 獲取選項數據
     *
     * @return JsonResponse
     */
    public static function select(): JsonResponse
    {
        return InfoService::select()->export()->json();
    }

    /**
     * 新增管理員信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function append(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
            'email' => ['required', 'string', 'email:rfc,dns'],
            'pass' => [
                'required',
                'string',
                // 必須八位以上且帶至少一個數字且至少包含一個字母
                Password::min(8)->numbers()->letters(),
            ],
            'role_id' => ['required', 'integer'],
        ]);

        return InfoService::append(
            $requestParams['account'],
            $requestParams['email'],
            $requestParams['pass'],
            $requestParams['role_id'],
        )->export()->json();
    }

    /**
     * 修改管理員信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function modify(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'id' => ['required', 'integer'],
            'account' => ['required', 'string'],
            'email' => ['required', 'string'],
            'role_id' => ['required', 'integer'],
        ]);

        $user = $request::user('sanctum');
        if ((int) $user->id === (int) $requestParams['id']) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '不允許編輯自身賬號信息'
            )->export()->json();
        }

        return InfoService::modify(
            $requestParams['id'],
            $requestParams['account'],
            $requestParams['email'],
            $requestParams['role_id'],
        )->export()->json();
    }

    /**
     * 刪除管理員信息
     *
     * @param  Request  $request
     * @todo 暫時不打算支持
     */
    public function delete(Request $request): void
    {

    }

}
