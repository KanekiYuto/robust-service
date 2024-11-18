<?php

/*
|--------------------------------------------------------------------------
| Backstage Routes
|--------------------------------------------------------------------------
|
*/

use App\Http\Controllers\Backstage\AbilityController;
use App\Routes\Route;

use App\Http\Controllers\Backstage\AdminController;
use App\Http\Controllers\Backstage\EmailController;
use App\Http\Controllers\Backstage\Admin\LogController as AdminLogController;
use App\Http\Controllers\Backstage\Admin\InfoController as AdminInfoController;
use App\Http\Controllers\Backstage\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Backstage\System\InfoController as SystemInfoController;

Route::group(function () {

    /* 管理员相关 */
    Route::group(function () {

        /* 管理员信息相关 */
        Route::group(function () {
            Route::get('paging')->finish();
            Route::get('select')->finish();
            Route::post('append')->finish();
            Route::post('modify')->finish();
        })->controller(
            AdminInfoController::class
        )->prefixAndName('info');

        Route::group(function () {
            Route::get('paging')->finish();
            Route::get('select')->finish();
            Route::post('append')->finish();
            Route::post('modify')->finish();
            Route::post('ability')->finish();
        })->controller(
            AdminRoleController::class
        )->prefixAndName('role');

        Route::group(function () {

            Route::post('login')->withoutMiddleware([
                'auth:admin',
            ])->finish();

            Route::post('logout')->finish();
            Route::post('account')->finish();
            Route::post('email')->finish();
            Route::post('pass')->finish();
            Route::get('info')->finish();

        })->withoutMiddleware(['backstage.ability']);

        Route::group(function () {
            Route::get('paging')->finish();
        })->controller(
            AdminLogController::class
        )->prefixAndName('log');

    })->controller(
        AdminController::class
    )->prefixAndName('admin');

    /* 系统相关 */
    Route::group(function () {

        Route::group(function () {
            Route::get('base')->finish();
        })->controller(
            SystemInfoController::class
        )->prefixAndName('info');

    })->withoutMiddleware([
        'backstage.ability'
    ])->prefixAndName('system');

    /* 能力相关 */
    Route::group(function () {
        Route::get('abilities')->finish();
        Route::get('groups')->finish();
    })->controller(
        AbilityController::class
    )->prefixAndName('ability');

    /* 邮件相关 */
    Route::group(function () {
        Route::post('send')->finish();
    })->controller(
        EmailController::class
    )->withoutMiddleware([
        'backstage.ability'
    ])->prefixAndName('email');

})->middleware(['auth:admin', 'backstage.ability']);
