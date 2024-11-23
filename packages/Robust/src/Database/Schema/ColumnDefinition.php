<?php

namespace KanekiYuto\Robust\Database\Schema;

/**
 * 列定义
 *
 * @author KanekiTuto
 */
class ColumnDefinition
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
     * 是否隐藏列
     *
     * @var bool
     */
    protected bool $hide = false;

    /**
     * 列参数
     *
     * @var ColumnTypeParams
     */
    protected ColumnTypeParams $typeParams;

    /**
     * 创建一个新列定义实例
     *
     * @param string $field
     * @param string $comment
     * @param ColumnTypeParams $typeParams
     *
     * @return void
     */
    public function __construct(string $field, string $comment, ColumnTypeParams $typeParams)
    {
        $this->field = $field;
        $this->comment = $comment;
        $this->typeParams = $typeParams;
    }

    /**
     * 设置为隐藏列 - 不设置默认非隐藏
     *
     * @param bool $hide
     *
     * @return ColumnDefinition
     */
    public function hide(bool $hide = true): ColumnDefinition
    {
        $this->hide = $hide;

        return $this;
    }

    /**
     * get Field
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
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

    /**
     * get Type Params
     *
     * @return ColumnTypeParams
     */
    public function getTypeParams(): ColumnTypeParams
    {
        return $this->typeParams;
    }

    /**
     * get Hide
     *
     * @return bool
     */
    public function getHide(): bool
    {
        return $this->hide;
    }

}
