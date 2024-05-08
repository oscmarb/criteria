<?php

namespace Oscmarb\Criteria\Filter\Condition;

final class FilterValue
{
    public function __construct(private string|int|float|array|bool|null $value)
    {
    }

    public function value(): string|int|float|array|bool|null
    {
        return $this->value;
    }
}