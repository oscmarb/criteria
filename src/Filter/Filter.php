<?php

namespace Oscmarb\Criteria\Filter;

abstract class Filter
{
    public function toPrimitives(): array
    {
        return CriteriaFilterSerializer::serialize($this);
    }

    public static function fromPrimitives(array $data): self
    {
        return CriteriaFilterSerializer::deserialize($data);
    }
}