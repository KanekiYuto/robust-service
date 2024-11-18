<?php

namespace Kaneki\Diverse\Equation;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder as QueryBuilder;

/**
 * [Equation]
 *
 * @todo 后续重构此类
 * @author KanekiYuto
 */
class Equation
{

    /**
     * [Builder] 类
     *
     * @var EloquentBuilder|QueryBuilder
     */
    private EloquentBuilder|QueryBuilder $model;

    /**
     * 列信息
     *
     * @var array
     */
    private array $columns = [];

    /**
     * 构建 [Equation]
     *
     * @param  EloquentBuilder|QueryBuilder  $model
     * @param  array|null  $columns
     * @param  array  $aliases
     * @return static
     */
    public static function build(
        EloquentBuilder|QueryBuilder $model,
        array|null $columns = null,
        array $aliases = []
    ): static {
        // 如果没有给值则取白名单中的所有值
        if (is_null($columns)) {
            $columns = $model->getModel()->getFillable();
        }

        return new static($model, $columns, $aliases);
    }

    /**
     * 构造基础信息
     *
     * @param  EloquentBuilder|QueryBuilder  $model
     * @param  array  $columns
     * @param  array  $aliases
     */
    private function __construct(
        EloquentBuilder|QueryBuilder $model,
        array $columns = [],
        array $aliases = []
    ) {
        $this->model = $model;

        $this->pushColumns($columns);
        $this->pushColumnsAliases($aliases);
    }

    /**
     * 设置列的完整段（如果不存在则使用模型的表名称）
     *
     * @param  string  $column
     * @param  string|null  $table
     * @return string
     */
    private function tableAs(string $column, string $table = null): string
    {
        if (empty($table)) {
            $table = $this->model->getModel()->getTable();
        }

        return "$table.$column";
    }

    /**
     * 设置列别名
     *
     * @param  string  $alias
     * @param  string  $column
     * @return string
     */
    private function columnAs(string $alias, string $column): string
    {
        return "$column as $alias";
    }

    /**
     * 把列信息加入到属性中
     *
     * @param  array  $columns
     * @param  string  $table
     * @return void
     */
    private function pushColumns(array $columns, string $table = ''): void
    {
        foreach ($columns as $column) {
            $this->columns[] = $this->tableAs($column, $table);
        }
    }

    /**
     * 把別名信息添加到属性中
     *
     * @param  array  $aliases
     * @param  string  $table
     * @return void
     */
    private function pushColumnsAliases(array $aliases, string $table = ''): void
    {
        foreach ($aliases as $column => $alias) {
            $column = $this->tableAs($column, $table);
            if (!in_array($column, $this->columns)) {
                continue;
            }

            $this->columns[array_search($column, $this->columns)] = $this->columnAs($alias, $column);
        }
    }

    /**
     * [where] 條件組
     *
     * @param  Formulas  $formulas
     * @param  string  $operator
     * @param  string  $boolean
     * @return Equation
     */
    public function where(
        Formulas $formulas,
        string $operator = '=',
        string $boolean = 'and'
    ): static {
        $formulas = $formulas->getFormulas();

        foreach ($formulas as $formula) {
            $this->model = $this->model->where(
                $this->tableAs($formula->getColumn(), $formula->getTable()),
                $operator,
                $formula->getValue(),
                $boolean
            );
        }

        return $this;
    }

    /**
     * [where-in] 條件組
     *
     * @param  Formulas  $formulas
     * @param  string  $boolean
     * @param  bool  $not
     * @return Equation
     */
    public function whereBetween(
        Formulas $formulas,
        string $boolean = 'and',
        bool $not = false
    ): static {
        $formulas = $formulas->getFormulas();

        foreach ($formulas as $formula) {
            $this->model = $this->model->whereBetween(
                $this->tableAs($formula->getColumn(), $formula->getTable()),
                $formula->getValue(),
                $boolean,
                $not
            );
        }

        return $this;
    }

    /**
     * 為構建方程式的模型設置 [join]
     *
     * @param  EloquentBuilder|QueryBuilder  $model
     * @param  string  $foreignKey
     * @param  string  $localKey
     * @param  string  $operator
     * @param  array  $columns
     * @param  array  $aliases
     * @return Equation
     */
    public function joinAsTheTable(
        EloquentBuilder|QueryBuilder $model,
        string $foreignKey,
        string $localKey,
        string $operator = '=',
        array $columns = [],
        array $aliases = []
    ): static {
        $table = $model->getModel()->getTable();

        if (empty($columns)) {
            $columns = $model->getModel()->getFillable();
        }

        $this->model = $this->model->join(
            $table,
            $this->tableAs($foreignKey, $table),
            $operator,
            $this->tableAs($localKey)
        );

        $this->pushColumns($columns, $table);
        $this->pushColumnsAliases($aliases, $table);

        return $this;
    }

    /**
     * 獲取所有記錄的列
     *
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * 導出模型對象
     *
     * @return EloquentBuilder|QueryBuilder
     */
    public function export(): EloquentBuilder|QueryBuilder
    {
        return $this->model;
    }

}
