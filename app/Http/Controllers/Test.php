<?php

namespace App\Http\Controllers;

use KanekiYuto\Handy\Support\Facades\Preacher;
use KanekiYuto\Handy\Preacher\PreacherResponse;

class Test
{

    public static function test(): PreacherResponse
    {
        return Preacher::base();
    }

}
