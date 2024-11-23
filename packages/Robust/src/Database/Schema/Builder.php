<?php

namespace KanekiYuto\Robust\Database\Schema;

use Closure;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema as LaravelSchema;
use Illuminate\Support\Facades\Storage;
use KanekiYuto\Robust\Cascades\Console\CascadeCommand;

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
    }

    /**
     * 使用文件驱动
     *
     * @return Filesystem
     */
    public static function useDisk(): Filesystem
    {
        return Storage::build([
            'driver' => 'local',
            'root' => self::getMigrationPath(),
        ]);
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

}
