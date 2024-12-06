<?php

namespace App\Cascade\ExtendsModels\PersonalAccess;

use Laravel\Sanctum\PersonalAccessToken as Model;
use KanekiYuto\Handy\Trace\TraceEloquent;

/**
 * Cascade generation
 *
 * @author KanekiYuto
 */
class TokensExtendsModel extends Model
{

	/**
	 * Trace class
	 *
	 * @var string<TraceEloquent>
	 */
	protected string $trace;

}