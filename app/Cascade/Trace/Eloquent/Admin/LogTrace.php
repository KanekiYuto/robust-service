<?php

namespace App\Cascade\Trace\Eloquent\Admin;

use KanekiYuto\Handy\Trace\TraceEloquent;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class LogTrace extends TraceEloquent
{

    /**
     * 表名称
     *
     * @var string
     */
	const TABLE = 'admin_log';

    /**
     * 主键
     *
     * @var string
     */
	const PRIMARY_KEY = self::ID;

    /**
	 * 管理员日志ID
	 *
	 * @var string
	 */
	const ID = 'id';
	
	/**
	 * 管理员ID
	 *
	 * @var string
	 */
	const ADMIN_ID = 'admin_id';
	
	/**
	 * API名称
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
	 * 请求IP
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
	 * 修改时间
	 *
	 * @var string
	 */
	const UPDATED_AT = 'updated_at';
	

    /**
     * 隐藏列
     *
     * @var array<int, string>
     */
    const HIDDEN = [];

    /**
     * 可填充的列
     *
     * @var array<string>
     */
    const FILLABLE = [self::ID, self::ADMIN_ID, self::API, self::PAYLOAD, self::HEADERS, self::RESPONSE, self::IPADDRESS, self::CREATED_AT, self::UPDATED_AT];

}
