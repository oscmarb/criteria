<?php

namespace Oscmarb\Criteria\Filter\Condition;

final class FilterField
{
    public function __construct(private string $value)
    {
        $this->assert();
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assert(): void
    {
        if (true === empty($this->value)) {
            throw new CriteriaFilterFieldCanNotBeEmptyException();
        }
    }
}