<?php

namespace Kaneki\Diverse\Cascade;

/**
 * 将有关数据库的所有信息串连 [Cascade]
 *
 * @author KanekiYuto
 */
abstract class Cascade
{

    /**
     * 运行迁移
     *
     * @return void
     */
    protected function up(): void
    {
        // ...
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

}
