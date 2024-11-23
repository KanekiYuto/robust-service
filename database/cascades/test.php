<?php

use Kaneki\Diverse\Cascade\Cascade;
use Kaneki\Diverse\Database\Schema\Blueprint;
use Kaneki\Diverse\Support\Facades\Schema;

return new class extends Cascade {

    /**
     * 运行迁移
     *
     * @return void
     */
    protected function up(): void
    {
        Schema::create('cascade', function (Blueprint $blueprint) {
            $blueprint->field('id')->hide();
        }, '测试');
    }

    /**
     * 回滚迁移
     *
     * @return void
     */
    protected function down(): void
    {
        // ...
    }

};
