<?php

namespace App\Models\Admin;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\AuthenticateModel as Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Cascade\Models\Admin\RoleModel as AdminRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as RoleTrace;

class Info extends Model
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
		$trace = $this->trace;

		$account = $this->getAttribute($trace::ACCOUNT);
		$email = $this->getAttribute($trace::EMAIL);

		// @todo 缩写成一条查询
		$account = $this->newQuery()
			->where($trace::ACCOUNT, $account)
			->exists();

		$email = $this->newQuery()
			->where($trace::EMAIL, $email)
			->exists();

		// 账号与邮箱唯一性保证
		if ($account || $email) {
			return false;
		}

		return parent::performInsert($query);
	}

}
