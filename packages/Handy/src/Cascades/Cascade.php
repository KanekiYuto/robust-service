<?php

namespace KanekiYuto\Handy\Cascades;

use KanekiYuto\Handy\Cascades\Console\CascadeCommand;
use KanekiYuto\Handy\Database\Schema\Builder;
use KanekiYuto\Handy\Support\Facades\Schema;

/**
 * 将所有信息都进行串连 [Cascade]
 *
 * @author KanekiYuto
 */
abstract class Cascade
{

    /**
     * 设置 Cascade Command
     *
     * @param CascadeCommand $command
     *
     * @return void
     */
    public function setCascadeCommand(CascadeCommand $command): void
    {
        Builder::useCascadeCommand($command);
        Schema::useCascadeCommand($command);
    }

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
