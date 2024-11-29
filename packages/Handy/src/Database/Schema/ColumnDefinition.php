<?php

namespace KanekiYuto\Handy\Database\Schema;

use Closure;
use KanekiYuto\Handy\Database\Schema\Constants\DefaultColumnParams;

/**
 * 列定义
 *
 * @author KanekiTuto
 */
class ColumnDefinition
{

    /**
     * 列参数
     *
     * @var ColumnParams
     */
    private ColumnParams $columnParams;

    /**
     * 构建一个新列迁移参数实例
     *
     * @param ColumnParams $columnParams
     *
     * @return void
     */
    public function __construct(ColumnParams $columnParams)
    {
        $this->columnParams = $columnParams;
    }

    /**
     * get Column Params
     *
     * @return ColumnParams
     */
    public function getColumnParams(): ColumnParams
    {
        return $this->columnParams;
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param bool $value
     *
     * @return self
     */
    public function nullable(bool $value = DefaultColumnParams::NULLABLE): self
    {
        $params = (object)[];

        if ($value !== DefaultColumnParams::NULLABLE) {
            $params->value = $value;
        }

        $this->columnParams->setMigrationParam('nullable', $params);

        return $this;
    }


    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param string $comment
     *
     * @return self
     */
    public function comment(string $comment): self
    {
        $this->columnParams->setComment($comment);

        $this->columnParams->setMigrationParam('comment', (object)[
            'comment' => $comment
        ]);

        return $this;
    }

    /**
     * 与 Laravel Blueprint 保持一致
     *
     * @param bool $value
     *
     * @return self
     */
    public function primary(bool $value = DefaultColumnParams::PRIMARY): self
    {
        $params = (object)[];

        if ($value !== DefaultColumnParams::PRIMARY) {
            $params->value = $value;
        }

        $this->columnParams->setMigrationParam('primary', $params);

        return $this;
    }

    /**
     * 标记为隐藏列
     *
     * @param bool $value
     *
     * @return self
     */
    public function hide(bool $value = DefaultColumnParams::HIDE): self
    {
        $this->columnParams->setHide($value);

        return $this;
    }

    /**
     * 指定转换类型
     *
     * @param Closure $value
     *
     * @return self
     */
    public function cast(Closure $value): self
    {
        $this->columnParams->setCasts($value);

        return $this;
    }

}
