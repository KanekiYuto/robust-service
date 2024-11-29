<?php

namespace KanekiYuto\Handy\Cascades;

use Closure;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Storage;
use KanekiYuto\Handy\Cascades\Make\EloquentTrace;
use KanekiYuto\Handy\Cascades\Make\Migration;

/**
 * 构建 - [Builder]
 *
 * @author KanekiTuto
 */
class Builder
{

    /**
     * 表名称
     *
     * @var string
     */
    private static string $table;

    /**
     * 表备注
     *
     * @var string
     */
    private static string $comment;

    /**
     * 创建实例
     *
     * @param string $table
     * @param Closure $callback
     * @param string $comment
     *
     * @return void
     */
    public static function create(
        string  $table,
        Closure $callback,
        string  $comment = ''
    ): void
    {
        self::$table = $table;
        self::$comment = $comment;

        $blueprint = new Blueprint(self::$table, self::$comment);

        $callback($blueprint);

        (new Migration($blueprint))->create();
        (new EloquentTrace($blueprint))->create();
    }

    /**
     * 使用文件驱动
     *
     * @param string $root
     * @return Filesystem
     */
    public static function useDisk(string $root): Filesystem
    {
        return Storage::build([
            'driver' => 'local',
            'root' => $root,
        ]);
    }

    /**
     * 获取存根目录
     *
     * @return string
     */
    public static function getStubsPath(): string
    {
        return self::getPackagePath() . DIRECTORY_SEPARATOR . 'stubs';
    }

    /**
     * 获取包的根路径
     *
     * @return string
     */
    public static function getPackagePath(): string
    {
        return dirname(__DIR__, 2);
    }

    /**
     * 获取 [Migration] 文件夹地址
     *
     * @return string
     */
    public static function getMigrationPath(): string
    {
        $databasePath = database_path();

        return $databasePath . DIRECTORY_SEPARATOR . 'migrations';
    }

    /**
     * 获取 [ORM] 模型跟踪路径
     *
     * @return string
     */
    public static function getEloquentTracePath(): string
    {
        $appPath = self::getAppPath();

        return $appPath . DIRECTORY_SEPARATOR . 'EloquentTraces';
    }

    /**
     * 获取应用路径
     *
     * @return string
     */
    public static function getAppPath(): string
    {
        $basePath = base_path();

        return $basePath . DIRECTORY_SEPARATOR . 'app';
    }

}
