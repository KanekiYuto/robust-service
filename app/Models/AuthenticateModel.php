<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Diverse\Support\Timestamp;
use KanekiYuto\Handy\Cascades\Model\AuthenticateModel as Model;

class AuthenticateModel extends Model
{

	/**
	 * 创建前执行的操作
	 *
	 * @param  Builder  $query
	 *
	 * @return bool
	 */
	protected function performInsert(Builder $query): bool
	{
		$trace = $this->trace;

		$this->setAttribute($trace::ID, Timestamp::millisecond());
		$this->setAttribute($trace::CREATED_AT, Timestamp::second());
		$this->setAttribute($trace::UPDATED_AT, Timestamp::second());

		return parent::performInsert($query);
	}

	/**
	 * 执行一个模型更新操作
	 *
	 * @param  Builder  $query
	 *
	 * @return bool
	 */
	protected function performUpdate(Builder $query): bool
	{
		$trace = $this->trace;

		// 维护时间戳
		$this->setAttribute($trace::UPDATED_AT, Timestamp::second());

		return parent::performUpdate($query);
	}

}