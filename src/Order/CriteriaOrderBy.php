<?php

namespace Oscmarb\Criteria\Order;

final class CriteriaOrderBy
{
    public function __construct(private string $value)
    {
        $this->assert();
    }

    private function assert(): void
    {
        if (true === empty($this->value)) {
            throw new CriteriaOrderByValueCanNotBeEmptyException();
        }
    }

    public function value(): string
    {
        return $this->value;
    }
}