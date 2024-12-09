<?php

use App\Models\Admin\Role as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use KanekiYuto\Handy\Foundation\Database\Eloquent\Casts\AutoTimezone;
use KanekiYuto\Handy\Foundation\Activity\Eloquent\Activity as EloquentActivity;

return Cascade::configure()->withTable(
    'admin_role',
    '管理员权限表'
)->withBlueprint(function (Blueprint $table) {
    $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员角色ID');
    $table->string('name', 32)->fillable()->comment('管理员角色名称');
    $table->string('explain', 64)->nullable()->fillable()->comment('管理员角色说明');
    $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
    $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
})->withModel(Model::class, EloquentActivity::class);
