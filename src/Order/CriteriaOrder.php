<?php

namespace Oscmarb\Criteria\Order;

final class CriteriaOrder
{
    public const ORDER_BY = 'order_by';
    public const ORDER_TYPE = 'order_type';

    public static function asc(string $orderBy): self
    {
        return self::create($orderBy, CriteriaOrderType::ASC);
    }

    public static function desc(string $orderBy): self
    {
        return self::create($orderBy, CriteriaOrderType::DESC);
    }

    public static function create(string $orderBy, string $orderType): self
    {
        return new self(new CriteriaOrderBy($orderBy), new CriteriaOrderType($orderType));
    }

    public static function createOrNull(?string $orderBy, ?string $orderType): ?self
    {
        return null === $orderBy || null === $orderType ? null : self::create($orderBy, $orderType);
    }

    public function __construct(private CriteriaOrderBy $orderBy, private CriteriaOrderType $orderType)
    {
    }

    public function orderBy(): CriteriaOrderBy
    {
        return $this->orderBy;
    }

    public function orderType(): CriteriaOrderType
    {
        return $this->orderType;
    }

    public function toPrimitives(): array
    {
        return [
            self::ORDER_BY => $this->orderBy->value(),
            self::ORDER_TYPE => $this->orderType->value(),
        ];
    }

    public static function fromPrimitives(array $data): self
    {
        return self::create($data[self::ORDER_BY], $data[self::ORDER_TYPE]);
    }
}