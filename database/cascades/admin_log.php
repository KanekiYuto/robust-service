<?php

use App\Models\Admin\Log as Model;
use KanekiYuto\Handy\Cascades\Cascade;
use KanekiYuto\Handy\Cascades\Blueprint;
use KanekiYuto\Handy\Cascades\Casts\AutoTimezone;

return Cascade::configure()->withTable(
	'admin_log',
	'管理员日志表'
)->withBlueprint(function (Blueprint $table) {
	$table->bigInteger('id')->primary()->unique()->comment('管理员日志ID');
	$table->bigInteger('admin_id')->comment('管理员ID');
	$table->string('api', 128)->comment('API名称');
	$table->ipAddress('ipaddress')->comment('请求IP');

	$table->json('payload')->cast(function (){
		return 'json';
	})->comment('请求荷载');
	$table->json('headers')->cast(function (){
		return 'json';
	})->comment('请求头');
	$table->json('response')->cast(function (){
		return 'json';
	})->comment('响应参数');
	$table->bigInteger('created_at')->cast(function () {
		return AutoTimezone::class;
	})->comment('创建时间');
	$table->bigInteger('updated_at')->cast(function () {
		return AutoTimezone::class;
	})->comment('修改时间');
})->withModel(Model::class);