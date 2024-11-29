<?php

namespace KanekiYuto\Handy\Cascades;

use KanekiYuto\Handy\Cascades\Constants\ColumnTypeConstant;
use KanekiYuto\Handy\Cascades\Constants\DefaultColumnParams;

/**
 * 蓝图 - [Blueprint]
 *
 * [Builder] 在实际工作中会先构建 [Migration] 所需的列参数
 *
 * 然后再为其进行其他参数的构建，同时尽可能保证与原有方法使用一致
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
     * @var ColumnDefinition[]
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
     * 与 Laravel Blueprint 保持一致
     *
     * @param string $field
     * @param bool $autoIncrement
     * @param bool $unsigned
     *
     * @return ColumnDefinition
     */
    public function bigInteger(
        string $field,
        bool   $autoIncrement = DefaultColumnParams::AUTO_INCREMENT,
        bool   $unsigned = DefaultColumnParams::UNSIGNED
    ): ColumnDefinition
    {
        $params = (object)['column' => $field];

        if ($autoIncrement !== DefaultColumnParams::AUTO_INCREMENT) {
            $params->autoIncrement = $autoIncrement;
        }

        if ($unsigned !== DefaultColumnParams::UNSIGNED) {
            $params->unsigned = $autoIncrement;
        }

        $column = new ColumnDefinition(
            (new ColumnParams($field))
                ->setMigrationParam(ColumnTypeConstant::STRING, $params)
        );

        $this->columns[] = $column;

        return $column;
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param string $field
     * @param int|null $length
     *
     * @return ColumnDefinition
     */
    public function string(
        string   $field,
        int|null $length = DefaultColumnParams::LENGTH
    ): ColumnDefinition
    {
        $params = (object)['column' => $field];

        if ($length !== DefaultColumnParams::PRIMARY) {
            $params->length = $length;
        }

        $column = new ColumnDefinition(
            (new ColumnParams($field))
                ->setMigrationParam(ColumnTypeConstant::STRING, $params)
        );

        $this->columns[] = $column;

        return $column;
    }

    /**
     * 获取所有列信息
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * 获取表名
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * 获取表说明
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

}
