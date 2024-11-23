<?php

use KanekiYuto\Robust\Cascades\Cascade;
use KanekiYuto\Robust\Database\Schema\Blueprint;
use KanekiYuto\Robust\Support\Facades\Schema;

return new class extends Cascade {

    /**
     * 串连 - [migration]
     *
     * @return void
     */
    public function migration(): void
    {
        Schema::create('user', function (Blueprint $blueprint) {
            $blueprint->field('id','test_id');
        });
    }

};
