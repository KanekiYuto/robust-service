<?php

use App\Http\Controllers\Test;
use Illuminate\Support\Facades\Route;
use KanekiYuto\Handy\Support\Facades\Preacher;

Route::get('/test', function () {

    return Preacher::msg('test11111111111')->export();

});

Route::controller(Test::class)->group(function () {
    Route::get('/test1', 'test');
});
