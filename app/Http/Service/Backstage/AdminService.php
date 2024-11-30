<?php

namespace App\Http\Service\Backstage;

use App\Ability\Ability;
use App\Constants\BackstageConstant;
use App\Helpers\TokenHelpers;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as AdminInfoTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as AdminRoleTrace;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use KanekiYuto\Diverse\Preacher\Preacher;

/**
 * 管理员业务类
 *
 * @author KanekiYuto
 */
class AdminService
{

    /**
     * 验证账号
     *
     * @param  string  $account
     * @param  string  $pass
     * @return Preacher
     */
    private static function authentication(string $account, string $pass): Preacher
    {
        $admin = AdminInfo::query()->where(
            AdminInfoTrace::ACCOUNT,
            $account,
        )->first();

        if (is_null($admin)) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '账号不存在'
            );
        }

        if (!Hash::check($pass, $admin->pass)) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '密码错误'
            );
        }

        return Preacher::receipt($admin);
    }

    /**
     * 签发授权令牌
     *
     * @param  object  $model
     * @param  int  $validity
     * @return Preacher
     */
    public static function token(object $model, int $validity): Preacher
    {
        // 获取模型能力
        $abilityColumn = AdminRoleTrace::ABILITIES;
        $roleInfo = $model->role;
        $ability = empty($roleInfo) ? [] : $roleInfo->$abilityColumn;

        [$tokenId, $tokenBody] = TokenHelpers::issue($model, $ability, $validity);

        return Preacher::receipt((object) [
            'tokenId' => $tokenId,
            'tokenBody' => $tokenBody,
        ]);
    }

    /**
     * 账号登录
     *
     * @param  string  $account
     * @param  string  $pass
     * @return Preacher
     */
    public static function login(string $account, string $pass): Preacher
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
     * 获取用户信息
     *
     * @param  Request  $request
     * @return Preacher
     */
    public static function info(Request $request): Preacher
    {
        $user = $request::user(BackstageConstant::GUARD);

        $token = self::token(
            $user,
            BackstageConstant::TOKEN_VALIDITY
        );

		// 获取所有拥有的能力
        $roleInfo = $user->role;
        $abilityColumn = AdminRoleTrace::ABILITIES;
        $abilities = Ability::permission($roleInfo->$abilityColumn);

        return Preacher::receipt((object) [
            'id' => $user[AdminInfoTrace::ID],
            'account' => $user[AdminInfoTrace::ACCOUNT],
            'email' => $user[AdminInfoTrace::EMAIL],
            'role' => $user->role[AdminRoleTrace::NAME],
            'permissions' => $abilities,
            'token' => $token->getReceipt(),
        ]);
    }

    /**
     * 修改管理员账号信息
     *
     * @param  int  $id
     * @param  string  $account
     * @return Preacher
     */
    public static function account(int $id, string $account): Preacher
    {
        $model = AdminInfo::query();
        $model = $model->where(AdminInfoTrace::ACCOUNT, $account);
        $model = $model->where(AdminInfoTrace::ID, '<>', $id);
        if ($model->exists()) {
            return Preacher::code(
                Preacher::RESP_CODE_WARN
            )->setMsg('账号已存在');
        }

        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::ACCOUNT;
        $model->$column = $account;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(Preacher::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 修改管理员邮箱
     *
     * @param  int  $id
     * @param  int  $code
     * @param  string  $email
     * @return Preacher
     */
    public static function email(
        int $id,
        int $code,
        string $email
    ): Preacher {
        $theCode = Cache::get('backstage-admin-modify-email');
        if (empty($theCode)) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '验证码已过期',
            );
        }

        if ($code === $theCode) {
            return Preacher::msgCode(
                Preacher::RESP_CODE_WARN,
                '验证码无效',
            );
        }

        $model = AdminInfo::query();
        $model = $model->where(AdminInfoTrace::EMAIL, $email);
        $model = $model->where(AdminInfoTrace::ID, '<>', $id);
        if ($model->exists()) {
            return Preacher::code(
                Preacher::RESP_CODE_WARN
            )->setMsg('邮箱已存在');
        }

        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::EMAIL;
        $model->$column = $email;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(Preacher::RESP_CODE_FAIL, '修改失败')
        );
    }

    /**
     * 更改管理员密码
     *
     * @param  int  $id
     * @param  string  $pass
     * @return Preacher
     */
    public static function pass(int $id, string $pass): Preacher
    {
        $model = AdminInfo::query()->find($id);

        $column = AdminInfoTrace::PASS;
        $model->$column = Hash::make($pass);

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(Preacher::RESP_CODE_FAIL, '修改失败')
        );
    }

}
