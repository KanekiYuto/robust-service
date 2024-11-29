<?php

namespace KanekiYuto\Handy\Cascades;

use KanekiYuto\Handy\Cascades\Console\CascadeCommand;
use KanekiYuto\Handy\Support\Facades\Schema;

/**
 * 将所有信息都进行串连 [Cascade]
 *
 * @todo 需要检查重新构建
 *
 * @author KanekiYuto
 */
abstract class Cascade
{

    /**
     * 获取类名
     *
     * @return string
     */
    public function getClassName(): string
    {
        return __CLASS__;
    }

    /**
     * 串连 - [migration]
     *
     * @return void
     */
    protected function migration(): void
    {
        // ...
    }

}
