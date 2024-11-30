<?php

namespace App\Http\Controllers\Backstage;

use App\Constants\BackstageConstant;
use App\Http\Service\Backstage\AdminService;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use KanekiYuto\Diverse\Preacher\Preacher;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

/**
 * 管理员控制器
 *
 * @author KanekiYuto
 */
class AdminController
{

    /**
     * 管理员登录
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
            'pass' => ['required', 'string'],
        ]);

        return AdminService::login(
            $requestParams['account'],
            $requestParams['pass'],
        )->export()->json();
    }

    /**
     * 退出登录
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $admin = $request::user(BackstageConstant::GUARD);

        $admin->currentAccessToken()->delete();

        return Preacher::msg('退出登录成功')
            ->export()->json();
    }

    /**
     * 获取管理员信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function info(Request $request): JsonResponse
    {
        return AdminService::info($request)->export()->json();
    }

    /**
     * 修改管理员账号信息
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function account(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
        ]);

        $admin = $request::user(BackstageConstant::GUARD);
        $account = AdminService::account(
            $admin->id,
            $requestParams['account']
        );

        $admin = AdminInfo::query()->find($admin->id);
        $token = AdminService::token($admin, BackstageConstant::TOKEN_VALIDITY);

        return $account->setReceipt(
            $token->getReceipt()
        )->export()->json();
    }

    /**
     * 修改管理员邮箱
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function email(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'email' => ['required', 'string'],
            'code' => ['required', 'integer'],
        ]);

        $admin = $request::user(BackstageConstant::GUARD);

        return AdminService::email(
            $admin->id,
            $requestParams['code'],
            $requestParams['email']
        )->export()->json();
    }

    /**
     * 更改管理员密码
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function pass(Request $request): JsonResponse
    {
        $requestParams = $request::validate([
            'original' => ['required', 'string'],
            'fresh' => ['required', 'string'],
        ]);

        $admin = $request::user(BackstageConstant::GUARD);

        if (!Hash::check($requestParams['original'], $admin->pass)) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '原密码错误'
            )->export()->json();
        }

        $pass = AdminService::pass(
            $admin->id,
            $requestParams['fresh']
        );

        $admin = AdminInfo::query()->find($admin->id);
        $token = AdminService::token(
            $admin,
            BackstageConstant::TOKEN_VALIDITY
        );

        return $pass->setReceipt(
            $token->getReceipt()
        )->export()->json();
    }

}
