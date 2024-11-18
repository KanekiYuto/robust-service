<?php

namespace App\Models\Traces\Admin;

use Kaneki\Diverse\Trace\TraceEloquent;

/**
 * 追踪类 （帮助 IDE 更好的发现）
 *
 * @author KanekiYuto
 */
class Log extends TraceEloquent
{

    /**
     * 表名称
     *
     * @var string
     */
    const TABLE = 'admin_log';

    /**
     * 管理员日志 - [ID]
     *
     * @var string
     */
    const ID = 'id';

    /**
     * 管理员 - [ID]
     *
     * @var string
     */
    const ADMIN_ID = 'admin_id';

    /**
     * 接口名称
     *
     * @var string
     */
    const API = 'api';

    /**
     * 请求荷载
     *
     * @var string
     */
    const PAYLOAD = 'payload';

    /**
     * 请求头
     *
     * @var string
     */
    const HEADERS = 'headers';

    /**
     * 响应参数
     *
     * @var string
     */
    const RESPONSE = 'response';

    /**
     * [IP] - 地址
     *
     * @var string
     */
    const IPADDRESS = 'ipaddress';

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
