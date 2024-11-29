<?php

use KanekiYuto\Handy\Cascades\Cascade;
use KanekiYuto\Handy\Database\Schema\Blueprint;
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
     * 串连 - [migration]
     *
     * @return void
     */
    public function migration(): void
    {
        Schema::create(table: 'admin_info', callback: function (Blueprint $blueprint) {
            $blueprint->bigInteger('id')->primary()->comment('主键');
            $blueprint->string('account', 32)->hide()->comment('账号');
            $blueprint->string('test')->hide();
        }, comment: '管理员信息表');
    }

};
