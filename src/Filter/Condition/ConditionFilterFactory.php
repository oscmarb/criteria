<?php

namespace Oscmarb\Criteria\Filter\Condition;

final class ConditionFilterFactory
{
    public static function create(string $field, string $operator, mixed $value): ConditionFilter
    {
        return new ConditionFilter(new FilterField($field), new FilterOperator($operator), new FilterValue($value));
    }

    public static function createEqual(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::EQUAL, $value);
    }

    public static function createNotEqual(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::NOT_EQUAL, $value);
    }

    public static function createContains(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::CONTAINS, $value);
    }

    public static function createIn(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::IN, $value);
    }

    public static function createNotIn(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::NOT_IN, $value);
    }
}