<?php

namespace App\Models\Admin;

use App\Models\BaseModel as Model;
use App\Cascade\Models\Admin\InfoModel;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Log extends Model
{

	/**
	 * 绑定管理员信息 [一对一关联]
	 *
	 * @return HasOne
	 */
	public function admin(): HasOne
	{
		return $this->hasOne(
			InfoModel::class,
			'id',
			'admin_id'
		);
	}

}