<?php

use App\Models\Admin\Info as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use KanekiYuto\Handy\Foundation\Database\Eloquent\Casts\AutoTimezone;
use App\Activity\Eloquent\Admin\Info as EloquentActivity;

return Cascade::configure()->withTable(
    'admin_info',
    '管理员信息表'
)->withBlueprint(function (Blueprint $table) {
    $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员ID');
    $table->string('account', 32)->fillable()->comment('账号');
    $table->bigInteger('admin_role_id')->fillable()->index()->comment('角色ID');
    $table->string('email', 32)->fillable()->comment('邮箱');
    $table->string('pass', 512)->fillable()->hidden()->comment('密码');
    $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
    $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
})->withModel(Model::class, EloquentActivity::class);
