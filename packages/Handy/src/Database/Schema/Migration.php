<?php

namespace KanekiYuto\Handy\Database\Schema;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;

/**
 * Migration - [构建工具]
 *
 * @author KanekiTuto
 */
class Migration
{

    /**
     * Blueprint
     *
     * @var Blueprint
     */
    private Blueprint $blueprint;

    /**
     * 存根
     *
     * @var string
     */
    private string $stub;

    /**
     * 创建一个新构建实例
     *
     * @param Blueprint $blueprint
     *
     * @return void
     */
    public function __construct(Blueprint $blueprint)
    {
        $this->blueprint = $blueprint;
    }

    /**
     * 创建并执行实例
     *
     * @return void
     */
    public function create(): void
    {
        note('开始创建 Migration...');

        $stubsDisk = Builder::useDisk(Builder::getStubsPath());
        $this->stub = $stubsDisk->get('migration.stub');

        if (empty($this->stub)) {
            error('创建失败...存根无效或不存在...');
            return;
        }

        $this->trace();
        $this->table();
        $this->comment();
        $this->blueprint();

        $migrationPath = Builder::getMigrationPath();
        $migrationDisk = Builder::useDisk($migrationPath);
        $fileName = $this->getFileName();
        $migrationDisk = $migrationDisk->put($fileName, $this->stub);

        if (!$migrationDisk) {
            error('创建失败...写入文件失败...');
            return;
        }

        info('Migration...创建完成！');
        warning("文件路径: [$migrationPath/$fileName]");
    }

    /**
     * 载入追踪
     *
     * @return void
     */
    private function trace(): void
    {
        $this->stub = $this->replace(
            '{{ trace }}',
            EloquentTrace::getClassName($this->blueprint->getTable())
        );
    }

    /**
     * 替换
     *
     * @param string $search
     * @param string $replace
     *
     * @return Stringable
     */
    private function replace(string $search, string $replace): Stringable
    {
        return Str::of($this->stub)
            ->replace($search, $replace);
    }

    /**
     * 载入表信息
     *
     * @return void
     */
    private function table(): void
    {
        $this->stub = $this->replace(
            '{{ table }}',
            "TheTrace::TABLE"
        );
    }

    /**
     * 载入说明信息
     *
     * @return void
     */
    private function comment(): void
    {
        $this->stub = $this->replace(
            '{{ comment }}',
            $this->blueprint->getComment()
        );
    }

    /**
     * 载入蓝图信息
     *
     * @return void
     */
    private function blueprint(): void
    {
        $columns = $this->blueprint->getColumns();
        $templates = [];

        foreach ($columns as $column) {
            $columnParams = $column->getColumnParams();

            // 先插入类型筛选
            $template = "@table";

            $template = $this->migrationParams($columnParams, $template);

            // 最终拼接
            $template .= ';';
            $template = Str::of($template)->replace('@', '$');

            $templates[] = $template;
        }

        $this->stub = $this->replace(
            '{{ blueprint }}',
            implode("\n\t\t\t", $templates)
        );
    }

    /**
     * 处理迁移参数
     *
     * @param ColumnParams $columnParams
     * @param string $template
     *
     * @return string
     */
    private function migrationParams(ColumnParams $columnParams, string $template): string
    {
        $migrationParams = $columnParams->getMigrationParams();

        // 遍历所有迁移参数
        collect($migrationParams)->map(function (MigrationParams $migrationParam) use (&$template) {
            // 不使用的参数不输出
            if (!$migrationParam->isUse()) {
                return $migrationParam;
            }

            // 获取必要信息
            $fn = $migrationParam->getFn();
            $paramsTemplate = "->$fn(";
            $params = $migrationParam->getParams();
            $paramsValues = [];

            // 遍历从参数值 按照 [PHP8] 指定参数名称的方式进行生成
            foreach ($params as $key => $val) {
                // 判断可以处理的类型
                if (!in_array(gettype($val), ['string', 'boolean', 'double', 'integer'])) {
                    continue;
                }

                $paramsValue = "$key: ";

                $val = match (gettype($val)) {
                    'string' => "'$val'",
                    'boolean' => $this->boolToString($val),
                    default => $val
                };

                // 指定的参数与列引用变量
                if ($key === 'column') {
                    $field = Str::of($val)
                        ->replace("'", '')
                        ->upper();
                    $val = "TheTrace::$field";
                }

                $paramsValue .= $val;
                $paramsValues[] = $paramsValue;
            }

            // 拼接成模板
            $paramsTemplate .= implode(', ', $paramsValues);
            $paramsTemplate .= ')';
            $template .= $paramsTemplate;

            return $migrationParam;
        });

        return $template;
    }

    /**
     * 将布尔值转换为字符串
     *
     * @param bool $bool
     *
     * @return string
     */
    private function boolToString(bool $bool): string
    {
        return $bool ? 'true' : 'false';
    }

    /**
     * 获取文件名称
     *
     * @return string
     */
    private function getFileName(): string
    {
        $filename = 'create_';
        $table = $this->blueprint->getTable();
        $filename .= $table;

        return "$filename.php";
    }

}
