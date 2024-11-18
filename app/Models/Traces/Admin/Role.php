<?php

namespace App\Models\Traces\Admin;

use Kaneki\Diverse\Trace\TraceEloquent;

/**
 * 追踪类 （帮助 IDE 更好的发现）
 *
 * @author KanekiYuto
 */
class Role extends TraceEloquent
{

    /**
     * 表名称
     *
     * @var string
     */
    const TABLE = 'admin_role';

    /**
     * 管理员角色 ID
     *
     * @var string
     */
    const ID = 'id';

    /**
     * 角色名称
     *
     * @var string
     */
    const NAME = 'name';

    /**
     * 角色说明
     *
     * @var string
     */
    const EXPLAIN = 'explain';

    /**
     * 角色能力
     *
     * @var string
     */
    const ABILITIES = 'abilities';

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
     * 隐藏列
     *
     * @var array
     */
    const HIDE = [];

}
