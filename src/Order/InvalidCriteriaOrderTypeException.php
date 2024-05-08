<?php

namespace Oscmarb\Criteria\Order;

final class InvalidCriteriaOrderTypeException extends \RuntimeException
{
    /**
     * @param string[] $validOrders
     */
    public function __construct(private string $order, private array $validOrders)
    {
        parent::__construct(sprintf('%s is not a valid order type value. Valid values: %s', $this->order, implode(',', $this->validOrders)));
    }

    public function order(): string
    {
        return $this->order;
    }

    public function validOrders(): array
    {
        return $this->validOrders;
    }
}