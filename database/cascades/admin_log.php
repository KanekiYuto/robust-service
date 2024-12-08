<?php

use App\Models\Admin\Log as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use KanekiYuto\Handy\Foundation\Cast\AutoTimezone;
use KanekiYuto\Handy\Foundation\Activity\Eloquent\Activity as EloquentActivity;

return Cascade::configure()->withTable(
    'admin_log',
    '管理员日志表'
)->withBlueprint(function (Blueprint $table) {
    $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员日志ID');
    $table->bigInteger('admin_id')->fillable()->comment('管理员ID');
    $table->string('api', 128)->fillable()->comment('API名称');
    $table->ipAddress('ipaddress')->fillable()->comment('请求IP');
    $table->json('payload')->cast('json')->fillable()->comment('请求荷载');
    $table->json('headers')->cast('json')->fillable()->comment('请求头');
    $table->json('response')->cast('json')->fillable()->comment('响应参数');
    $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
    $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
})->withModel(Model::class, EloquentActivity::class);
