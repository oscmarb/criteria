<?php

namespace Oscmarb\Criteria\Result;

/**
 * @template T
 *
 * @implements CriteriaResult<T>
 */
final class InMemoryCriteriaResult implements CriteriaResult
{
    /**
     * @param T[] $elements
     */
    public function __construct(private int $count, private array $elements)
    {
    }

    public function count(): int
    {
        return $this->count;
    }

    public function isEmpty(): bool
    {
        return empty($this->elements);
    }

    public function elements(): array
    {
        return $this->elements;
    }

    public function first(): mixed
    {
        return self::_first($this->elements);
    }

    public function oneOrException(): mixed
    {
        if (1 !== $this->count()) {
            throw new OneElementExpectedException();
        }

        /* @phpstan-ignore-next-line */
        return $this->first();
    }

    /**
     * @param T[] $elements
     *
     * @return ?T
     */
    private static function _first(array $elements): mixed
    {
        foreach ($elements as $element) {
            return $element;
        }

        return null;
    }
}