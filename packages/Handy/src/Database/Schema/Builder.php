<?php

namespace KanekiYuto\Handy\Database\Schema;

use Closure;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema as LaravelSchema;
use Illuminate\Support\Facades\Storage;
use KanekiYuto\Handy\Cascades\Console\CascadeCommand;

/**
 * 构建 - [Builder]
 *
 * @author KanekiTuto
 */
class Builder
{

    /**
     * 是否生成 Migration
     *
     * @var bool
     */
    protected static bool $migration;

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
     * Cascade 命令行
     *
     * @var CascadeCommand
     */
    private static CascadeCommand $command;

    /**
     * 创建实例
     *
     * @param string $table
     * @param Closure $callback
     * @param bool $migration
     * @param string $comment
     *
     * @return void
     */
    public static function create(string $table, Closure $callback, bool $migration = false, string $comment = ''): void
    {
        self::$table = $table;
        self::$comment = $comment;
        self::$migration = $migration;

        $blueprint = new Blueprint(self::$table, self::$comment);
        $callback($blueprint);

        (new EloquentTrace($blueprint))->create();
        (new Migration($blueprint))->create();
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
        return self::getRobustPath() . DIRECTORY_SEPARATOR . 'Stubs';
    }

    /**
     * 获取包的根路径
     *
     * @return string
     */
    public static function getRobustPath(): string
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
        $databasePath = self::$command->getLaravel()->databasePath();
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
        $basePath = self::$command->getLaravel()->basePath();

        return $basePath . DIRECTORY_SEPARATOR . 'app';
    }

    /**
     * 使用 CascadeCommand
     *
     * @param CascadeCommand $command
     *
     * @return void
     */
    public static function useCascadeCommand(CascadeCommand $command): void
    {
        self::$command = $command;
    }

    /**
     * 继承原有 dropIfExists 方法
     *
     * @param string $table
     *
     * @return void
     */
    public static function dropIfExists(string $table): void
    {
        if (self::$migration) {
            LaravelSchema::dropIfExists($table);
        }
    }

    public function useCode()
    {

    }

}
