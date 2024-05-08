<?php

namespace Oscmarb\Criteria;

use Oscmarb\Criteria\Filter\Condition\ConditionFilterFactory;
use Oscmarb\Criteria\Filter\Filter;
use Oscmarb\Criteria\Filter\Filters;
use Oscmarb\Criteria\Filter\Logic\AndFilter;
use Oscmarb\Criteria\Filter\Logic\OrFilter;
use Oscmarb\Criteria\Order\CriteriaOrder;
use Oscmarb\Criteria\Order\CriteriaOrders;
use Oscmarb\Criteria\Pagination\CriteriaLimit;
use Oscmarb\Criteria\Pagination\CriteriaOffset;

final class CriteriaBuilder
{
    private Filters $filters;
    private CriteriaOrders $orders;
    private ?CriteriaOffset $offset;
    private ?CriteriaLimit $limit;

    public static function create(Criteria $criteria = null): self
    {
        return new self($criteria);
    }

    public function __construct(Criteria $criteria = null)
    {
        $this->filters = $criteria?->filters() ?? Filters::empty();
        $this->orders = $criteria?->orders() ?? CriteriaOrders::empty();
        $this->offset = $criteria?->offset();
        $this->limit = $criteria?->limit();
    }

    public function addAndFilter(Filter ...$filters): self
    {
        return $this->addFilter(AndFilter::create(...$filters));
    }

    public function addOrFilter(Filter ...$filters): self
    {
        return $this->addFilter(OrFilter::create(...$filters));
    }

    public function addEqualFilter(string $field, mixed $value): self
    {
        return $this->addFilter(ConditionFilterFactory::createEqual($field, $value));
    }

    public function addNotEqualFilter(string $field, mixed $value): self
    {
        return $this->addFilter(ConditionFilterFactory::createNotEqual($field, $value));
    }

    public function addContainsFilter(string $field, mixed $value): self
    {
        return $this->addFilter(ConditionFilterFactory::createContains($field, $value));
    }

    public function addInFilter(string $field, mixed $value): self
    {
        return $this->addFilter(ConditionFilterFactory::createIn($field, $value));
    }

    public function addNotInFilter(string $field, mixed $value): self
    {
        return $this->addFilter(ConditionFilterFactory::createNotIn($field, $value));
    }

    public function addFilter(Filter $filter): self
    {
        $this->filters->add($filter);

        return $this;
    }

    public function addFilters(Filter ...$filters): self
    {
        foreach ($filters as $filter) {
            $this->filters->add($filter);
        }

        return $this;
    }

    public function clearFilters(): self
    {
        $this->filters = Filters::empty();

        return $this;
    }

    public function addOrder(CriteriaOrder $order): self
    {
        $this->orders->add($order);

        return $this;
    }

    public function addOrders(CriteriaOrder ...$orders): self
    {
        foreach ($orders as $order) {
            $this->addOrder($order);
        }

        return $this;
    }

    public function removeOrders(): self
    {
        $this->orders = CriteriaOrders::empty();

        return $this;
    }

    public function addDescOrderIfNotExists(string $orderBy): self
    {
        return $this->addOrderIfNotExists(CriteriaOrder::desc($orderBy));
    }

    public function addAscOrderIfNotExists(string $orderBy): self
    {
        return $this->addOrderIfNotExists(CriteriaOrder::asc($orderBy));
    }

    public function addOrderIfNotExists(CriteriaOrder $order): self
    {
        if (false === $this->hasOrder()) {
            $this->orders->add($order);
        }

        return $this;
    }

    private function hasOrder(): bool
    {
        return false === $this->orders->isEmpty();
    }

    public function addDescOrder(string $orderBy): self
    {
        return $this->addOrder(CriteriaOrder::desc($orderBy));
    }

    public function addAscOrder(string $orderBy): self
    {
        return $this->addOrder(CriteriaOrder::asc($orderBy));
    }

    public function setOffset(CriteriaOffset|int|null $offset): self
    {
        if (true === is_int($offset)) {
            $offset = new CriteriaOffset($offset);
        }

        $this->offset = $offset;

        return $this;
    }

    public function removeOffset(): self
    {
        return $this->setOffset(null);
    }

    public function setLimit(CriteriaLimit|int|null $limit): self
    {
        if (true === is_int($limit)) {
            $limit = new CriteriaLimit($limit);
        }

        $this->limit = $limit;

        return $this;
    }

    public function removeLimit(): self
    {
        return $this->setLimit(null);
    }

    public function createCriteria(): Criteria
    {
        return new Criteria($this->filters, $this->orders, $this->offset, $this->limit);
    }
}