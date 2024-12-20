<?php

namespace App\Http\Controllers\Backstage;

use App\Constants\BackstageConstant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use App\Cascade\Models\Admin\InfoModel;
use Illuminate\Database\Eloquent\Model;
use App\Http\Service\Backstage\AdminService;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;

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
     *
     * @return PreacherResponse
     */
    public function login(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'account' => ['required', 'string'],
            'pass' => ['required', 'string'],
        ]);

        return AdminService::login($requestParams['account'], $requestParams['pass']);
    }

    /**
     * 退出登录
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function logout(Request $request): PreacherResponse
    {
        $user = $request::user(BackstageConstant::GUARD);

        if (!($user instanceof InfoModel)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        $currentAccessToken = $user->currentAccessToken();

        if (!($currentAccessToken instanceof Model)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        $currentAccessToken->delete();

        return Preacher::msg('退出登录成功');
    }

    /**
     * 获取管理员信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function info(Request $request): PreacherResponse
    {
        return AdminService::info($request);
    }

    /**
     * 修改管理员账号信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function account(Request $request): PreacherResponse
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

        return $account->setReceipt($token->getReceipt());
    }

    /**
     * 修改管理员邮箱
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function email(Request $request): PreacherResponse
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
        );
    }

    /**
     * 更改管理员密码
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public function pass(Request $request): PreacherResponse
    {
        $requestParams = $request::validate([
            'original' => ['required', 'string'],
            'fresh' => ['required', 'string'],
        ]);

        $admin = $request::user(BackstageConstant::GUARD);

        if (!Hash::check($requestParams['original'], $admin->pass)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '原密码错误'
            );
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

        return $pass->setReceipt($token->getReceipt());
    }

}
