<?php

namespace Oscmarb\Criteria\Pagination;

final class InvalidCriteriaOffsetException extends \RuntimeException
{
    public function __construct(private int $offset)
    {
        parent::__construct(sprintf('%s is not a valid criteria offset, it must be zero or greater.', $this->offset));
    }

    public function offset(): int
    {
        return $this->offset;
    }
}