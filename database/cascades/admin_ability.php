<?php

use App\Models\Admin\Ability as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use KanekiYuto\Handy\Foundation\Cast\AutoTimezone;

return Cascade::configure()->withTable(
	'admin_ability',
	'管理员能力信息表'
)->withBlueprint(function (Blueprint $table) {
	$jsonCast = function () {
		return 'json';
	};

	$autoTimezoneCast = function () {
		return AutoTimezone::class;
	};

	$table->bigInteger('id')->primary()->unique()->comment('能力 - [ID]');
	$table->string('name', 32)->comment('能力名称');
	$table->string('explain', 64)->nullable()->comment('能力解释');
	$table->uuid('current_uuid')->comment('唯一标识');
	$table->uuid('parent_uuid')->comment('父级唯一标识');
	$table->json('server_routing')->cast($jsonCast)->comment('服务端路由');
	$table->json('client_routing')->cast($jsonCast)->comment('客户端路由');
	$table->json('operation')->cast($jsonCast)->comment('允许操作的权限');
	$table->enum('type', ['group', 'ability'])->comment('能力类型');
	$table->bigInteger('created_at')->cast($autoTimezoneCast)->comment('创建时间');
	$table->bigInteger('updated_at')->cast($autoTimezoneCast)->comment('修改时间');
})->withModel(Model::class);
