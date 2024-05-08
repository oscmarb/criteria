<?php

namespace Oscmarb\Criteria\Filter\Logic;

use Oscmarb\Criteria\Filter\Filter;

abstract class LogicFilter extends Filter
{
    public const FILTERS = 'filters';

    private array $filters;

    final public static function create(Filter ...$filters): static
    {
        return new static(...$filters);
    }

    final public function __construct(Filter ...$filters)
    {
        $this->filters = $filters;

        $this->ensureContainsAlmostTwoFilters();
    }

    /**
     * @return Filter[]
     */
    public function filters(): array
    {
        return $this->filters;
    }

    private function ensureContainsAlmostTwoFilters(): void
    {
        if (count($this->filters) < 2) {
            throw new \RuntimeException('Logic filter needs almost two filters');
        }
    }
}