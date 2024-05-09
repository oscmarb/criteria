<?php

namespace Oscmarb\Criteria\Filter;

final class Filters
{
    public static function empty(): self
    {
        return new self([]);
    }

    /**
     * @param Filter[] $values
     */
    public function __construct(private array $values)
    {
    }

    public function values(): array
    {
        return $this->values;
    }

    public function add(Filter $filter): void
    {
        $this->values[] = $filter;
    }

    public function toPrimitives(): array
    {
        return array_map(static fn(Filter $filter) => $filter->toPrimitives(), $this->values);
    }

    public static function fromPrimitives(array $data): self
    {
        return new self(array_map(static fn(array $filterData) => Filter::fromPrimitives($filterData), $data));
    }
}