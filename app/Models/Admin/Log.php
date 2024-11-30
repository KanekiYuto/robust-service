<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Diverse\Support\Timestamp;
use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheTrace;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Cascade\Models\Admin\InfoModel as AdminInfo;

class Log extends Model
{

	/**
	 * 创建前执行的操作
	 *
	 * @param  Builder  $query
	 * @return bool
	 */
	protected function performInsert(Builder $query): bool
	{
		if (empty($this->getAttribute(TheTrace::ID))) {
			$this->setAttribute(TheTrace::ID, Timestamp::millisecond());
		}

		$this->setAttribute(TheTrace::CREATED_AT, Timestamp::second());
		$this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

		return parent::performInsert($query);
	}

	/**
	 * 执行一个模型更新操作
	 *
	 * @param  Builder  $query
	 * @return bool
	 */
	protected function performUpdate(Builder $query): bool
	{
		// 维护时间戳
		$this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

		return parent::performUpdate($query);
	}

	/**
	 * 绑定管理员信息表 [一对一关联]
	 *
	 * @return HasOne
	 */
	public function admin(): HasOne
	{
		return $this->hasOne(
			AdminInfo::class,
			'id',
			'admin_id'
		);
	}

}