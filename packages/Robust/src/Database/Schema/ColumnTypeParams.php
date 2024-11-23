<?php

namespace KanekiYuto\Robust\Database\Schema;

/**
 * 列类型参数
 *
 * @author KanekiTuto
 */
class ColumnTypeParams
{

    /**
     * AUTO INCREMENT
     *
     * @var bool
     */
    const AUTO_INCREMENT = false;

    /**
     * UNSIGNED
     *
     * @var bool
     */
    const UNSIGNED = false;

    /**
     * auto Increment
     *
     * @var bool
     */
    private bool $autoIncrement = self::AUTO_INCREMENT;

    /**
     * unsigned
     *
     * @var bool
     */
    private bool $unsigned = self::UNSIGNED;

    /**
     * get Auto Increment
     *
     * @return bool
     */
    public function getAutoIncrement(): bool
    {
        return $this->autoIncrement;
    }

    /**
     * set Auto Increment
     *
     * @param bool $autoIncrement
     *
     * @return ColumnTypeParams
     */
    public function setAutoIncrement(bool $autoIncrement): ColumnTypeParams
    {
        $this->autoIncrement = $autoIncrement;

        return $this;
    }

    /**
     * get Unsigned
     *
     * @return bool
     */
    public function getUnsigned(): bool
    {
        return $this->unsigned;
    }

    /**
     * set Unsigned
     *
     * @param bool $unsigned
     *
     * @return ColumnTypeParams
     */
    public function setUnsigned(bool $unsigned): ColumnTypeParams
    {
        $this->unsigned = $unsigned;

        return $this;
    }

}
