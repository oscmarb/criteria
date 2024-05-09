<?php

namespace Oscmarb\Criteria\Order;

final class CriteriaOrderType
{
    public const ASC = 'asc';
    public const DESC = 'desc';

    public function __construct(private string $value)
    {
        $this->assert();
    }

    public function isAsc(): bool
    {
        return self::ASC === $this->value;
    }

    public function isDesc(): bool
    {
        return self::DESC === $this->value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function assert(): void
    {
        if (false === in_array($this->value, $this->validOrders())) {
            throw new InvalidCriteriaOrderTypeException($this->value, $this->validOrders());
        }
    }

    private function validOrders(): array
    {
        return [self::ASC, self::DESC];
    }
}