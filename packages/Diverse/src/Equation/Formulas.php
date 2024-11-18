<?php

namespace Kaneki\Diverse\Equation;

/**
 * 公式 (複數) - [Formulas]
 *
 * @author KanekiYuto
 */
class Formulas
{

    /**
     * 構造函數 - 構造基本信息
     *
     * @param  array  $params
     * @param  array  $formulas
     */
    public function __construct(
        private readonly array $params,
        private array          $formulas = []
    ) {
    }

    /**
     * 創建一個新的公式並加入到組中
     *
     * @param  string  $column
     * @param  string  $field
     * @param  string  $table
     * @param  callable|null  $value
     * @return static
     */
    public function formula(
        string $column,
        string $field = '',
        string $table = '',
        callable $value = null
    ): static {
        if (empty($field)) {
            $field = $column;
        }

        if (isset($this->params[$field])) {
            $formula = new Formula(
                $column,
                $field,
                $table,
                $this->params[$field]
            );

            if (is_callable($value)) {
                $formula = $formula->setValue(
                    $value($formula->getValue())
                );
            }

            $this->formulas[] = $formula;
        }

        return $this;
    }

    /**
     * 獲取所有的公式
     *
     * @return array
     */
    public function getFormulas(): array
    {
        return $this->formulas;
    }

}
