<?php

namespace Oscmarb\Criteria;

use Oscmarb\Criteria\Filter\Filters;
use Oscmarb\Criteria\Order\CriteriaOrder;
use Oscmarb\Criteria\Order\CriteriaOrders;
use Oscmarb\Criteria\Pagination\CriteriaLimit;
use Oscmarb\Criteria\Pagination\CriteriaOffset;

class Criteria
{
    public const FILTERS = 'filters';
    public const ORDER = 'order';
    public const ORDERS = 'orders';
    public const OFFSET = 'offset';
    public const LIMIT = 'limit';

    private CriteriaOrders $orders;

    public function __construct(
        private Filters $filters,
        CriteriaOrders|CriteriaOrder|null $order = null,
        private ?CriteriaOffset $offset = null,
        private ?CriteriaLimit $limit = null,
    )
    {
        $this->setOrder($order);
    }

    private function setOrder(CriteriaOrders|CriteriaOrder|null $order): void
    {
        if (true === $order instanceof CriteriaOrder) {
            $this->orders = CriteriaOrders::fromOrder($order);

            return;
        }

        $this->orders = $order ?? CriteriaOrders::empty();
    }

    /**
     * @deprecated Use CriteriaBuilder instead
     */
    public function addOrderIfNotExists(CriteriaOrder $order): static
    {
        if (false === $this->orders->isEmpty()) {
            return $this;
        }

        $this->orders->add($order);

        return $this;
    }

    public function filters(): Filters
    {
        return $this->filters;
    }

    public function orders(): CriteriaOrders
    {
        return $this->orders;
    }

    public function offset(): ?CriteriaOffset
    {
        return $this->offset;
    }

    public function limit(): ?CriteriaLimit
    {
        return $this->limit;
    }

    private function toJson(): string
    {
        return \Safe\json_encode($this->toPrimitives());
    }

    public function equals(mixed $item): bool
    {
        return true === $item instanceof Criteria && $item->toJson() === $this->toJson();
    }

    public static function fromPrimitives(array $data): self
    {
        $offset = $data[self::OFFSET] ?? null;
        $limit = $data[self::LIMIT] ?? null;

        $order = null;

        if (true === isset($data[self::ORDER])) {
            $order = CriteriaOrder::fromPrimitives($data[self::ORDER]);
        } elseif (true === isset($data[self::ORDERS])) {
            $order = CriteriaOrders::fromPrimitives($data[self::ORDERS]);
        }

        return new self(
            Filters::fromPrimitives($data[self::FILTERS]),
            $order,
            null === $offset ? null : new CriteriaOffset($offset),
            null === $limit ? null : new CriteriaLimit($limit),
        );
    }

    public function toPrimitives(): array
    {
        return [
            self::FILTERS => $this->filters->toPrimitives(),
            self::ORDERS => $this->orders->toPrimitives(),
            self::OFFSET => $this->offset?->value(),
            self::LIMIT => $this->limit?->value(),
        ];
    }
}