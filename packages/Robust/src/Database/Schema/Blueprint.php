<?php

namespace KanekiYuto\Robust\Database\Schema;

/**
 * 蓝图 - [Blueprint]
 *
 * @author KanekiTuto
 */
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
     * @var ColumnTypeDefinition[]
     */
    protected array $columns = [];

    /**
     * 构建一个新的蓝图实例
     *
     * @param string $table
     * @param string $comment
     *
     * @return void
     */
    public function __construct(string $table, string $comment = '')
    {
        $this->table = $table;
        $this->comment = $comment;
    }

    /**
     * 设置字段信息
     *
     * @param string $field
     * @param string $comment
     *
     * @return ColumnTypeDefinition
     */
    public function field(string $field, string $comment = ''): ColumnTypeDefinition
    {
        $columnTypeDefinition = new ColumnTypeDefinition($field, $comment);
        $this->columns[] = $columnTypeDefinition;

        return $columnTypeDefinition;
    }

    /**
     * get Columns
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * get Table
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * get Comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

}
