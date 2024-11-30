<?php

use KanekiYuto\Handy\Cascades\Blueprint;
use KanekiYuto\Handy\Cascades\Cascade;
use KanekiYuto\Handy\Support\Facades\Schema;


/**
 * 实例文件
 *
 * @todo 增加生成模型的操作
 * @todo 增加模型的 [casts] 使用
 * @todo 增加模型其他方法使用 [trait] 引入的机制
 * @todo 固定函数的生命周期使用函数进行载入
 */
return new class extends Cascade {

    /**
     * Run Cascade
     *
     * @return void
     */
    public function run(): void
    {
        Schema::create(table: 'admin_info', callback: function (Blueprint $table) {
            $table->bigInteger('id')->primary()->unique()->comment('管理员ID');
            $table->string('account', 32)->comment('账号');
            $table->bigInteger('admin_role_id')->index()->comment('角色ID');
            $table->string('email', 32)->comment('邮箱');
            $table->string('pass', 512)->comment('密码');
            $table->bigInteger('created_at')->comment('创建时间');
            $table->bigInteger('updated_at')->comment('修改时间');
            $table->string('test')->charset('111')->after('id')->change();
        }, comment: '管理员信息表');
    }

};
