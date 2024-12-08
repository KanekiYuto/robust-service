<?php

namespace App\Cascade\Trace\Eloquent\Admin;

use KanekiYuto\Handy\Trace\EloquentTrace;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class RoleTrace extends EloquentTrace
{

    /**
     * 表名称
     *
     * @var string
     */
	const TABLE = 'admin_role';

    /**
     * 主键
     *
     * @var string
     */
	const PRIMARY_KEY = self::ID;

    /**
	 * 管理员角色ID
	 *
	 * @var string
	 */
	const ID = 'id';
	
	/**
	 * 管理员角色名称
	 *
	 * @var string
	 */
	const NAME = 'name';
	
	/**
	 * 管理员角色说明
	 *
	 * @var string
	 */
	const EXPLAIN = 'explain';
	
	/**
	 * 管理员角色能力
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
     * @var array<int, string>
     */
    const FILLABLE = [self::ID, self::NAME, self::EXPLAIN, self::ABILITIES, self::CREATED_AT, self::UPDATED_AT];

}
