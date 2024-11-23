<?php

namespace KanekiYuto\Robust\Database\Schema;

/**
 * 列类型定义
 *
 * @author KanekiTuto
 */
class ColumnTypeDefinition
{

    /**
     * 字段名称
     *
     * @var string
     */
    protected string $field;

    /**
     * 字段备注
     *
     * @var string
     */
    protected string $comment;

    /**
     * 列定义
     *
     * @var ColumnDefinition
     */
    protected ColumnDefinition $columnDefinition;

    /**
     * 创建一个新列定义实例
     *
     * @param string $field
     * @param string $comment
     */
    public function __construct(string $field, string $comment)
    {
        $this->field = $field;
        $this->comment = $comment;

        $this->columnDefinition = new ColumnDefinition(
            $this->field,
            $this->comment,
            new ColumnTypeParams()
        );
    }

    /**
     * 集成 [Laravel] 原有方法
     *
     * @param bool $autoIncrement
     * @param bool $unsigned
     *
     * @return ColumnDefinition
     */
    public function bigInteger(
        bool $autoIncrement = ColumnTypeParams::AUTO_INCREMENT,
        bool $unsigned = ColumnTypeParams::UNSIGNED
    ): ColumnDefinition
    {
        $this->columnDefinition = new ColumnDefinition(
            $this->field,
            $this->comment,
            (new ColumnTypeParams())
                ->setAutoIncrement($autoIncrement)
                ->setUnsigned($unsigned)
        );

        return $this->columnDefinition;
    }

    /**
     * get Column Definition
     *
     * @return ColumnDefinition
     */
    public function getColumnDefinition(): ColumnDefinition
    {
        return $this->columnDefinition;
    }

}
