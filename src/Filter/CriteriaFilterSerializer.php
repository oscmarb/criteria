<?php

namespace Oscmarb\Criteria\Filter;

use Oscmarb\Criteria\Filter\Condition\ConditionFilter;
use Oscmarb\Criteria\Filter\Condition\FilterField;
use Oscmarb\Criteria\Filter\Condition\FilterOperator;
use Oscmarb\Criteria\Filter\Condition\FilterValue;
use Oscmarb\Criteria\Filter\Logic\AndFilter;
use Oscmarb\Criteria\Filter\Logic\LogicFilter;
use Oscmarb\Criteria\Filter\Logic\OrFilter;

final class CriteriaFilterSerializer
{
    private const TYPE = 'type';

    private const OR_TYPE = 'or';
    private const AND_TYPE = 'and';
    private const CONDITION_TYPE = 'condition';

    public static function serialize(Filter $filter): array
    {
        if (true === $filter instanceof LogicFilter) {
            return [
                self::TYPE => true === $filter instanceof OrFilter ? self::OR_TYPE : self::AND_TYPE,
                LogicFilter::FILTERS => array_map(
                    static fn(Filter $filter) => self::serialize($filter),
                    $filter->filters(),
                ),
            ];
        }

        if (true === $filter instanceof ConditionFilter) {
            return [
                self::TYPE => self::CONDITION_TYPE,
                ConditionFilter::VALUE => $filter->value()->value(),
                ConditionFilter::FIELD => $filter->field()->value(),
                ConditionFilter::OPERATOR => $filter->operator()->value(),
            ];
        }

        throw new \RuntimeException('Unknown filter type');
    }

    public static function deserialize(array $data): Filter
    {
        $type = $data[self::TYPE];

        if (self::OR_TYPE === $type || self::AND_TYPE === $type) {
            $deserializedFilters = array_map(
                static fn(array $filterData) => self::deserialize($filterData),
                $data[LogicFilter::FILTERS],
            );

            if (self::OR_TYPE === $type) {
                return new OrFilter(...$deserializedFilters);
            }

            return new AndFilter(...$deserializedFilters);
        }

        if (self::CONDITION_TYPE === $type) {
            return new ConditionFilter(
                new FilterField($data[ConditionFilter::FIELD]),
                new FilterOperator($data[ConditionFilter::OPERATOR]),
                new FilterValue($data[ConditionFilter::VALUE] ?? null),
            );
        }

        throw new \RuntimeException(sprintf('Unknown %s filter type', $type));
    }
}