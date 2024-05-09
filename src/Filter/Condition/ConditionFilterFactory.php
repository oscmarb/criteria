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

    public static function createStartsWith(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::STARTS_WITH, $value);
    }

    public static function createEndsWith(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::ENDS_WITH, $value);
    }

    public static function createIn(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::IN, $value);
    }

    public static function createGt(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::GT, $value);
    }

    public static function createGte(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::GTE, $value);
    }

    public static function createLt(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::LT, $value);
    }

    public static function createLte(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::LTE, $value);
    }

    public static function createNotIn(string $field, mixed $value): ConditionFilter
    {
        return self::create($field, FilterOperator::NOT_IN, $value);
    }
}