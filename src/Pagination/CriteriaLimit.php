<?php

namespace Oscmarb\Criteria\Pagination;

final class CriteriaLimit
{
    public function __construct(private int $value)
    {
        $this->assert();
    }

    public function value(): int
    {
        return $this->value;
    }

    private function assert(): void
    {
        if ($this->value <= 0) {
            throw new InvalidCriteriaLimitException($this->value);
        }
    }
}