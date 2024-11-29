<?php

namespace KanekiYuto\Handy\Database\Schema;

use Closure;

/**
 * 参数 - [Cast]
 *
 * @author KanekiYuto
 */
class CastParams
{

    /**
     * 字段名
     *
     * @var string
     */
    protected string $field;

    /**
     * 返回值
     *
     * @var Closure
     */
    protected Closure $cast;

    /**
     * get Cast
     *
     * @return Closure
     */
    public function getCast(): Closure
    {
        return $this->cast;
    }

    /**
     * set Cast
     *
     * @param Closure $cast
     *
     * @return self
     */
    public function setCast(Closure $cast): self
    {
        $this->cast = $cast;

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
     * set Field
     *
     * @param string $field
     *
     * @return self
     */
    public function setField(string $field): self
    {
        $this->field = $field;

        return $this;
    }

}
