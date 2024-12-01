<?php

namespace App\Models\Traces;

use Kaneki\Diverse\Trace\TraceEloquent;

/**
 * 追踪类 （帮助 IDE 更好地发现）
 *
 * @author KanekiYuto
 */
class PersonalAccessToken extends TraceEloquent
{

	/**
	 * 表名称
	 *
	 * @var string
	 */
	const TABLE = 'personal_access_tokens';

	/**
	 * 私人访问令牌 ID
	 *
	 * @var string
	 */
	const ID = 'id';

	/**
	 * 令牌能力
	 *
	 * @var string
	 */
	const TOKENABLE = 'tokenable';

	/**
	 * 令牌名稱
	 *
	 * @var string
	 */
	const NAME = 'name';

	/**
	 * 令牌内容
	 *
	 * @var string
	 */
	const TOKEN = 'token';

	/**
	 * 令牌能力
	 *
	 * @var string
	 */
	const ABILITIES = 'abilities';

	/**
	 * 令牌最终使用时间
	 *
	 * @var string
	 */
	const LAST_USED_AT = 'last_used_at';

	/**
	 * 令牌过期时间
	 *
	 * @var string
	 */
	const EXPIRES_AT = 'expires_at';

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
	const HIDE = [self::TOKEN];

}
