<?php

use KanekiYuto\Handy\Cascade\Cascade;
use KanekiYuto\Handy\Cascade\Blueprint;

return Cascade::configure()
    ->withTable('test_info', '测试表')
    ->withMigration('', 'withMigration')
    ->withBlueprint(function (Blueprint $blueprint) {
        $blueprint->string('id');
    });
