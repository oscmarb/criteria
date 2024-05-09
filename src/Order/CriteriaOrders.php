<?php

namespace Oscmarb\Criteria\Order;

final class CriteriaOrders
{
    public static function empty(): self
    {
        return new self([]);
    }

    public static function fromOrder(CriteriaOrder $order): self
    {
        return new self([$order]);
    }

    /**
     * @param CriteriaOrder[] $orders
     */
    public static function fromArray(array $orders): self
    {
        return new self($orders);
    }

    /**
     * @param CriteriaOrder[] $values
     */
    public function __construct(private array $values)
    {
    }

    public function values(): array
    {
        return $this->values;
    }

    public function add(CriteriaOrder $order): void
    {
        $this->values[] = $order;
    }

    public function isEmpty(): bool
    {
        return true === empty($this->values);
    }

    public function toPrimitives(): array
    {
        return array_map(static fn(CriteriaOrder $order) => $order->toPrimitives(), $this->values);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(array_map(static fn(array $orderData) => CriteriaOrder::fromPrimitives($orderData), $data));
    }
}