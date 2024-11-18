<?php

namespace Kaneki\Diverse\Equation;

/**
 * 公式 - [Formula]
 *
 * @author KanekiYuto
 */
class Formula
{

    /**
     * 構造函數 - 構造基本信息
     *
     * @param  string  $column
     * @param  string  $field
     * @param  string  $table
     * @param  mixed  $value
     */
    public function __construct(
        private string $column = '',
        private string $field = '',
        private string $table = '',
        private mixed $value = ''
    ) {
    }

    /**
     * 獲取列名稱
     *
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * 設置列名稱
     *
     * @param  string  $column
     * @return static
     */
    public function setColumn(string $column): static
    {
        $this->column = $column;

        return $this;
    }

    /**
     * 獲取字段名稱
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * 設置字段名稱
     *
     * @param  string  $field
     * @return static
     */
    public function setField(string $field): static
    {
        $this->field = $field;

        return $this;
    }

    /**
     * 獲取字段所屬表名稱
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * 設置字段所屬表名稱
     *
     * @param  string  $table
     * @return static
     */
    public function setTable(string $table): static
    {
        $this->table = $table;

        return $this;
    }

    /**
     * 獲取值
     *
     * @return mixed
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * 設置值
     *
     * @param  mixed  $value
     * @return static
     */
    public function setValue(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

}
