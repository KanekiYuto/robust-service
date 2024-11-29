<?php

namespace KanekiYuto\Handy\Database\Schema;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\note;
use function Laravel\Prompts\warning;

/**
 * Eloquent Trace  - [构建工具]
 *
 * @author KanekiTuto
 **/
class EloquentTrace
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
     * 隐藏的字段
     *
     * @var array
     */
    private array $hides = [];

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
        note('开始创建 Eloquent Trace...');

        $stubsDisk = Builder::useDisk(Builder::getStubsPath());
        $this->stub = $stubsDisk->get('eloquent-trace.stub');

        if (empty($this->stub)) {
            error('创建失败...存根无效或不存在...');
            return;
        }

        $this->className();
        $this->tableConstantCode();
        $this->attributeConstantCode();
        $this->hideConstantCode();

        $className = $this->getClassName($this->blueprint->getTable());
        $tracePath = Builder::getEloquentTracePath();
        $eloquentTraceDisk = Builder::useDisk($tracePath);
        $eloquentTraceDisk = $eloquentTraceDisk->put(
            "$className.php",
            $this->stub
        );

        if (!$eloquentTraceDisk) {
            error('创建失败...写入文件失败...');
            return;
        }

        info('Eloquent Trace...创建完成！');
        warning("文件路径: [$tracePath/$className.php]");
    }

    /**
     * 载入文件类名
     *
     * @return void
     */
    public function className(): void
    {
        $this->stub = $this->replace(
            '{{ className }}',
            $this->getClassName($this->blueprint->getTable())
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
     * 生成文件类名
     *
     * @param string $table
     *
     * @return string
     */
    public static function getClassName(string $table): string
    {
        $table = Str::headline($table);
        $table = Str::of($table)->replace(' ', '');

        return $table . 'EloquentTrace';
    }

    /**
     * 载入表常量代码
     *
     * @return void
     */
    private function tableConstantCode(): void
    {
        $table = $this->blueprint->getTable();

        $templates = [];

        $templates = array_merge(
            $templates,
            $this->codeComment('隐藏列')
        );

        $templates[] = "const TABLE = '$table';";

        $this->stub = $this->replace(
            '{{ tableConstantCode }}',
            implode("\n\t", $templates)
        );
    }

    /**
     * 生成代码注释
     *
     * @param string $comment
     * @param string $retract
     * @param string $val
     *
     * @return array
     */
    private function codeComment(string $comment, string $retract = '', string $val = 'string'): array
    {
        $template = [];

        $template[] = "$retract/**";
        $template[] = " * $comment";
        $template[] = ' *';
        $template[] = " * @var $val";
        $template[] = ' */';

        return $template;
    }

    /**
     * 字段常量代码
     *
     * @return void
     */
    private function attributeConstantCode(): void
    {
        $columns = $this->blueprint->getColumns();
        $templates = [];

        foreach ($columns as $index => $column) {
            $columnDefinition = $column->getColumnParams();
            $template = [];

            $template = array_merge(
                $template,
                $this->codeComment(
                    $columnDefinition->getComment(),
                    $index !== 0 ? "\t" : ''
                )
            );

            $field = $columnDefinition->getField();
            $constantCode = Str::of($field)->upper();

            $template[] = "const $constantCode = '$field';";

            $template = implode("\n\t", $template);

            // 判断该列是否标记为隐藏
            if ($columnDefinition->isHide()) {
                $this->hides[] = $constantCode;
            }

            $templates[] = $template;
        }

        $this->stub = $this->replace(
            '{{ attributeConstantCode }}',
            implode("\n\n", $templates)
        );
    }

    /**
     * 隐藏属性从常量代码
     *
     * @return void
     */
    private function hideConstantCode(): void
    {
        $hides = collect($this->hides)->map(function (string $hide) {
            $hide = Str::of($hide)->upper();
            return "self::$hide";
        })->all();

        $hides = implode(', ', $hides);

        $templates = [];
        $templates = array_merge(
            $templates,
            $this->codeComment('隐藏列', '', 'array')
        );

        $templates[] = "const HIDE = [$hides];";

        $this->stub = $this->replace(
            '{{ hideConstantCode }}',
            implode("\n\t", $templates)
        );

    }

}
