<?php

namespace Kaneki\Diverse\Database\Schema;

use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;

class ColumnDefinition
{

    protected string $field;
    protected bool $hide = false;
    protected LaravelBlueprint $blueprint;

    public function __construct(string $field, LaravelBlueprint $blueprint)
    {
        $this->field = $field;
        $this->blueprint = $blueprint;
    }

    public function bigInteger($autoIncrement = false, $unsigned = false): self
    {
        $this->blueprint->bigInteger($this->field, $autoIncrement, $unsigned);

        return $this;
    }

    public function hide(bool $hide): self
    {
        $this->hide = $hide;

        return $this;
    }

}
