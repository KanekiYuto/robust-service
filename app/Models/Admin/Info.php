<?php

namespace App\Models\Admin;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Diverse\Support\Timestamp;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace as TheTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as RoleTrace;
use App\Cascade\Models\Admin\RoleModel as AdminRole;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Info extends Authenticate
{

	use HasApiTokens, HasFactory, Notifiable;

	public function casts(): array
	{
		return [
			RoleTrace::ABILITIES => 'json',
		];
	}

	/**
	 * 绑定管理员权限表 [一对一关联]
	 *
	 * @return HasOne
	 */
	public function role(): HasOne
	{
		return $this->hasOne(
			AdminRole::class,
			'id',
			'admin_role_id'
		);
	}

	/**
	 * 创建前执行的操作
	 *
	 * @param  Builder  $query
	 *
	 * @return bool
	 */
	protected function performInsert(Builder $query): bool
	{
		$this->setAttribute(TheTrace::ID, Timestamp::millisecond());
		$this->setAttribute(TheTrace::CREATED_AT, Timestamp::second());
		$this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

		$account = $this->getAttribute(TheTrace::ACCOUNT);
		$email = $this->getAttribute(TheTrace::EMAIL);

		// @todo 缩写成一条查询
		$account = $this->newQuery()
			->where(TheTrace::ACCOUNT, $account)
			->exists();

		$email = $this->newQuery()
			->where(TheTrace::EMAIL, $email)
			->exists();

		// 账号与邮箱唯一性保证
		if ($account || $email) {
			return false;
		}

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
		// 维护时间戳
		$this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

		return parent::performUpdate($query);
	}

}