<?php

use App\Models\BaseModel as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use KanekiYuto\Handy\Foundation\Cast\AutoTimezone;

return Cascade::configure()->withTable(
	'admin_role',
	'管理员权限表'
)->withBlueprint(function (Blueprint $table) {
	$table->bigInteger('id')->primary()->unique()->comment('管理员角色ID');
	$table->string('name', 32)->comment('管理员角色名称');
	$table->string('explain', 64)->nullable()->comment('管理员角色说明');

	$table->json('abilities')->cast(function () {
		return 'json';
	})->comment('管理员角色能力');
	$table->bigInteger('created_at')->cast(function () {
		return AutoTimezone::class;
	})->comment('创建时间');
	$table->bigInteger('updated_at')->cast(function () {
		return AutoTimezone::class;
	})->comment('修改时间');
})->withModel(Model::class);
