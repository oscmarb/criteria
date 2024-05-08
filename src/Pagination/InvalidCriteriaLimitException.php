<?php

namespace Oscmarb\Criteria\Pagination;

final class InvalidCriteriaLimitException extends \RuntimeException
{
    public function __construct(private int $limit)
    {
        parent::__construct(sprintf('%s is not a valid criteria limit, it must be greater than zero.', $this->limit));
    }

    public function limit(): int
    {
        return $this->limit;
    }
}