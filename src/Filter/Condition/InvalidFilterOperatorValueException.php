<?php

namespace Oscmarb\Criteria\Filter\Condition;

final class InvalidFilterOperatorValueException extends \RuntimeException
{
    /**
     * @param string[] $validOperators
     */
    public function __construct(private string $operator, private array $validOperators)
    {
        parent::__construct(sprintf('%s is not a valid operator. Valid operators: %s', $this->operator, implode(',', $this->validOperators)));
    }
}