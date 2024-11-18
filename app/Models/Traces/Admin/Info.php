<?php

namespace App\Models\Traces\Admin;

use Kaneki\Diverse\Trace\TraceEloquent;

/**
 * 追踪类 （帮助 IDE 更好的发现）
 *
 * @author KanekiYuto
 */
class Info extends TraceEloquent
{

    /**
     * 表名称
     *
     * @var string
     */
    const TABLE = 'admin_info';

    /**
     * 管理员 ID
     *
     * @var string
     */
    const ID = 'id';

    /**
     * 管理员账号
     *
     * @var string
     */
    const ACCOUNT = 'account';

    /**
     * 管理员角色 [ID]
     *
     * @var string
     */
    const ADMIN_ROLE_ID = 'admin_role_id';

    /**
     * 管理员密码
     *
     * @var string
     */
    const PASS = 'pass';

    /**
     * 管理员邮箱
     *
     * @var string
     */
    const EMAIL = 'email';

    /**
     * 创建时间
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * 更新时间
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * 隱藏列
     *
     * @var array
     */
    const HIDE = [self::PASS];

}
