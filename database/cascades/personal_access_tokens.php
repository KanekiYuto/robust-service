<?php

use Laravel\Sanctum\PersonalAccessToken as Model;
use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;

return Cascade::configure()->withTable(
    'personal_access_tokens',
    '私人授权令牌信息表'
)->withBlueprint(function (Blueprint $table) {
    $table->bigInteger('id')->comment('私人访问令牌ID');
    $table->morphs('tokenable')->comment('令牌能力');
    $table->string('name')->comment('令牌名称');
    $table->string('token', 64)->unique()->comment('令牌内容');
    $table->text('abilities')->nullable()->comment('令牌能力');
    $table->timestamp('last_used_at')->nullable()->comment('令牌最终使用时间');
    $table->timestamp('expires_at')->nullable()->comment('令牌过期时间');
    $table->bigInteger('created_at')->comment('创建时间');
    $table->bigInteger('updated_at')->comment('修改时间');
})->withModel(Model::class);
