<?php

namespace KanekiYuto\Handy\Cascades\Model;

use Illuminate\Database\Eloquent\Model;
use KanekiYuto\Handy\Trace\TraceEloquent;

/**
 * 基础模型
 *
 * @author KanekiYuto
 */
abstract class BaseModel extends Model
{

	/**
	 * 追踪类
	 *
	 * @var string
	 */
	protected string $trace = TraceEloquent::class;

}
