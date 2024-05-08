<?php

namespace Oscmarb\Criteria\Filter\Condition;

use Oscmarb\Criteria\Filter\Filter;

final class ConditionFilter extends Filter
{
    public const FIELD = 'field';
    public const OPERATOR = 'operator';
    public const VALUE = 'value';

    public function __construct(
        private FilterField $field,
        private FilterOperator $operator,
        private FilterValue $value,
    )
    {
    }

    public function field(): FilterField
    {
        return $this->field;
    }

    public function operator(): FilterOperator
    {
        return $this->operator;
    }

    public function value(): FilterValue
    {
        return $this->value;
    }
}