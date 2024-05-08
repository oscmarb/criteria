<?php

namespace Oscmarb\Criteria\Filter\Condition;

final class FilterOperator
{
    public const EQUAL = '=';
    public const NOT_EQUAL = '!=';
    public const GT = '>';
    public const GTE = '>=';
    public const LT = '<';
    public const LTE = '<=';
    public const CONTAINS = 'contains';
    public const IN = 'in';
    public const NOT_IN = 'not_in';
    public const STARTS_WITH = 'starts_with';
    public const ENDS_WITH = 'ends_with';

    public function __construct(private string $value)
    {
        $this->assert();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isEqual(): bool
    {
        return self::EQUAL === $this->value;
    }

    public function isNotEqual(): bool
    {
        return self::NOT_EQUAL === $this->value;
    }

    public function isGt(): bool
    {
        return self::GT === $this->value;
    }

    public function isGte(): bool
    {
        return self::GTE === $this->value;
    }

    public function isLt(): bool
    {
        return self::LT === $this->value;
    }

    public function isLte(): bool
    {
        return self::LTE === $this->value;
    }

    public function isContains(): bool
    {
        return self::CONTAINS === $this->value;
    }

    public function isIn(): bool
    {
        return self::IN === $this->value;
    }

    public function isNotIn(): bool
    {
        return self::NOT_IN === $this->value;
    }

    public function isStartsWith(): bool
    {
        return self::STARTS_WITH === $this->value;
    }

    public function isEndsWith(): bool
    {
        return self::ENDS_WITH === $this->value;
    }

    private function assert(): void
    {
        if (false === in_array($this->value, self::allOperators())) {
            throw new InvalidFilterOperatorValueException($this->value, self::allOperators());
        }
    }

    private static function allOperators(): array
    {
        return [
            self::EQUAL,
            self::NOT_EQUAL,
            self::GT,
            self::GTE,
            self::LT,
            self::LTE,
            self::CONTAINS,
            self::IN,
            self::NOT_IN,
            self::STARTS_WITH,
            self::ENDS_WITH,
        ];
    }
}