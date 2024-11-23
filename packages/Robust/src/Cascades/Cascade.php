<?php

namespace KanekiYuto\Robust\Cascades;

use KanekiYuto\Robust\Cascades\Console\CascadeCommand;
use KanekiYuto\Robust\Support\Facades\Schema;

/**
 * 将所有信息都进行串连 [Cascade]
 *
 * @author KanekiYuto
 */
abstract class Cascade
{

    protected CascadeCommand $command;

    public function setCascadeCommand(CascadeCommand $command): void
    {
        $this->command = $command;
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
