<?php

use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;
use Illuminate\Database\Eloquent\Model as Model;
use KanekiYuto\Handy\Foundation\Database\Eloquent\Casts\AutoTimezone;
use KanekiYuto\Handy\Foundation\Activity\Eloquent\Activity as EloquentActivity;

return Cascade::configure()->withTable(
    'admin_role_ability',
    '管理员角色能力信息表'
)->withBlueprint(function (Blueprint $table) {
    $table->bigInteger('id')->primary()->unique()->fillable()->comment('角色能力 - [ID]');
    $table->bigInteger('role_id')->fillable()->comment('角色 - [ID]');
    $table->bigInteger('ability_id')->fillable()->comment('能力 - [ID]');
    $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
    $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');
})->withModel(Model::class, EloquentActivity::class);
