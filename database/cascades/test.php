<?php

use App\Models\Admin\Info as Model;
use Handyfit\Framework\Cascade\Schema;
use Handyfit\Framework\Cascade\Cascade;
use App\Hook\Eloquent\Admin\Info as Hook;
use Handyfit\Framework\Cascade\Blueprint;
use Handyfit\Framework\Foundation\Database\Eloquent\Casts\AutoTimezone;

return Cascade::configure()->withTable(
    'admin_test',
    '管理员信息表'
)->withSchema(function (Schema $schema) {

    $schema::create(function (Blueprint $table) {

        $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员ID');
        $table->string('account', 32)->fillable()->comment('账号');
        $table->string('pass', 512)->fillable()->hidden()->comment('密码');
        $table->bigInteger('created_at')->cast(AutoTimezone::class)->fillable()->comment('创建时间');
        $table->bigInteger('updated_at')->cast(AutoTimezone::class)->fillable()->comment('修改时间');

    });

    $schema::table(function (Blueprint $table) {
        $table->bigInteger('id')->primary()->unique()->fillable()->comment('管理员ID');
    });

})->withMigration(comment: '测试')->withModel(Model::class, Hook::class);
