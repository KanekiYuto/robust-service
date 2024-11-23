<?php

namespace Kaneki\Diverse\Database\Schema;

use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;

class Blueprint
{

    /**
     * 表名称
     *
     * @var string
     */
    protected string $table;

    /**
     * 备注
     *
     * @var string
     */
    protected string $comment;

    /**
     * 列信息定义
     *
     * @var ColumnDefinition[]
     */
    protected array $columns = [];

    protected LaravelBlueprint $blueprint;

    public function __construct(string $table, LaravelBlueprint $blueprint, string $comment = '')
    {
        $this->table = $table;
        $this->comment = $comment;
        $this->blueprint = $blueprint;
    }

    public function field(string $field): ColumnDefinition
    {
        return new ColumnDefinition($field, $this->blueprint);
    }
}
