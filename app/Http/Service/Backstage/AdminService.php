<?php

namespace App\Http\Service\Backstage;

use App\Helpers\TokenHelpers;
use App\Constants\BackstageConstant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;
use App\Cascade\Models\Admin\InfoModel;
use App\Cascade\Models\Admin\RoleModel;
use Handyfit\Framework\Support\Facades\Preacher;
use Handyfit\Framework\Preacher\PreacherResponse;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as AdminInfoTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as AdminRoleTrace;

/**
 * 管理员业务类
 *
 * @author KanekiYuto
 */
class AdminService
{

    /**
     * 账号登录
     *
     * @param  string  $account
     * @param  string  $pass
     *
     * @return PreacherResponse
     */
    public static function login(string $account, string $pass): PreacherResponse
    {
        $auth = self::authentication($account, $pass);
        if (!$auth->isSucceed()) {
            return $auth;
        }

        $admin = $auth->getReceipt();

        return self::token(
            $admin,
            60 * 30
        )->setMsg('登录成功');
    }

    /**
     * 验证账号
     *
     * @param  string  $account
     * @param  string  $pass
     *
     * @return PreacherResponse
     */
    private static function authentication(string $account, string $pass): PreacherResponse
    {
        $admin = AdminInfo::query()->where(
            AdminInfoTrace::ACCOUNT,
            $account,
        )->first();

        if (is_null($admin)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '账号不存在'
            );
        }

        if (!Hash::check($pass, $admin->pass)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '密码错误'
            );
        }

        return Preacher::receipt($admin);
    }

    /**
     * 签发授权令牌
     *
     * @param  object  $model
     * @param  int     $validity
     *
     * @return PreacherResponse
     */
    public static function token(object $model, int $validity): PreacherResponse
    {
        [$tokenId, $tokenBody] = TokenHelpers::issue($model, [], $validity);

        return Preacher::receipt((object) [
            'tokenId' => $tokenId,
            'tokenBody' => $tokenBody,
        ]);
    }

    /**
     * 获取用户信息
     *
     * @param  Request  $request
     *
     * @return PreacherResponse
     */
    public static function info(Request $request): PreacherResponse
    {
        $user = $request::user(BackstageConstant::GUARD);

        if (!($user instanceof InfoModel)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_FAIL,
                '系统异常'
            );
        }

        $token = self::token(
            $user,
            BackstageConstant::TOKEN_VALIDITY
        );

        $roleInfo = $user->role();
        $roleModel = RoleModel::query()->find($roleInfo->value(RoleTrace::ID));
        $abilities = $roleModel->abilities()->get([
            AbilityTrace::CLIENT_ROUTING,
            AbilityTrace::OPERATION,
            AbilityTrace::TYPE,
        ]);

        $permissions = [];

        foreach ($abilities as $ability) {
            if (!empty($ability[AbilityTrace::CLIENT_ROUTING])) {
                $permissions[] = "@route:{$ability[AbilityTrace::CLIENT_ROUTING]}";
            }

            if (!empty($ability[AbilityTrace::OPERATION])) {
                foreach ($ability[AbilityTrace::OPERATION] as $key => $val) {
                    $permissions[] = "@$val:$key";
                }
            }
        }

        return Preacher::receipt((object) [
            'id' => $user[AdminInfoTrace::ID],
            'account' => $user[AdminInfoTrace::ACCOUNT],
            'email' => $user[AdminInfoTrace::EMAIL],
            'role' => $roleInfo->value(AdminRoleTrace::NAME),
            'permissions' => $permissions,
            'token' => $token->getReceipt(),
        ]);
    }

    /**
     * 修改管理员账号信息
     *
     * @param  int     $id
     * @param  string  $account
     *
     * @return PreacherResponse
     */
    public static function account(int $id, string $account): PreacherResponse
    {
        $model = AdminInfo::query();
        $model = $model->where(AdminInfoTrace::ACCOUNT, $account);
        $model = $model->where(AdminInfoTrace::ID, '<>', $id);

        if ($model->exists()) {
            return Preacher::code(
                PreacherResponse::RESP_CODE_WARN
            )->setMsg('账号已存在');
        }

        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::ACCOUNT;
        $model->$column = $account;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 修改管理员邮箱
     *
     * @param  int     $id
     * @param  int     $code
     * @param  string  $email
     *
     * @return PreacherResponse
     */
    public static function email(
        int $id,
        int $code,
        string $email
    ): PreacherResponse {
        $theCode = Cache::get('backstage-admin-modify-email');
        if (empty($theCode)) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '验证码已过期',
            );
        }

        if ($code === $theCode) {
            return Preacher::msgCode(
                PreacherResponse::RESP_CODE_WARN,
                '验证码无效',
            );
        }

        $model = AdminInfo::query();
        $model = $model->where(AdminInfoTrace::EMAIL, $email);
        $model = $model->where(AdminInfoTrace::ID, '<>', $id);
        if ($model->exists()) {
            return Preacher::code(
                PreacherResponse::RESP_CODE_WARN
            )->setMsg('邮箱已存在');
        }

        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::EMAIL;
        $model->$column = $email;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 更改管理员密码
     *
     * @param  int     $id
     * @param  string  $pass
     *
     * @return PreacherResponse
     */
    public static function pass(int $id, string $pass): PreacherResponse
    {
        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::PASS;
        $model->$column = Hash::make($pass);

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(PreacherResponse::RESP_CODE_FAIL, '修改失败')
        );
    }

}
