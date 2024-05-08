<?php

namespace Oscmarb\Criteria\Result;

/**
 * @template T
 *
 * @implements CriteriaResult<T>
 */
final class LazyCriteriaResult implements CriteriaResult
{
    /** @var T|null */
    private $first;
    private bool $isFirstFnExecuted = false;
    private bool $isOneOrNullFnExecuted = false;
    private ?int $count = null;

    /** @var T[]|null */
    private ?array $elements = null;

    /**
     * @param \Closure():int      $countFn
     * @param \Closure():array<T> $elementsFn
     * @param \Closure():?T       $firstFn
     * @param \Closure():?T       $oneOrExceptionFn
     * @param ?int                $maxElements
     */
    public function __construct(
        private \Closure $countFn,
        private \Closure $elementsFn,
        private \Closure $firstFn,
        private \Closure $oneOrExceptionFn,
        private ?int $maxElements = null,
    )
    {
    }

    public function count(): int
    {
        if (null === $this->count) {
            $this->count = ($this->countFn)();

            $this->loadDataFromCount();
        }

        /* @phpstan-ignore-next-line */
        return $this->count;
    }

    public function isEmpty(): bool
    {
        if (null !== $this->count) {
            return 0 === $this->count;
        }

        if (null !== $this->elements) {
            return empty($this->elements);
        }

        return null === $this->first();
    }

    public function elements(): array
    {
        if (null === $this->elements) {
            $this->elements = ($this->elementsFn)();

            $this->loadDataFromElements();
        }

        /* @phpstan-ignore-next-line */
        return $this->elements;
    }

    public function first()
    {
        if (false === $this->isFirstFnExecuted) {
            $this->first = ($this->firstFn)();
            $this->isFirstFnExecuted = true;

            $this->loadDataFromFirst();
        }

        return $this->first;
    }

    public function oneOrException()
    {
        if (
            (null !== $this->count && 1 !== $this->count)
            || (null !== $this->elements && 1 !== count($this->elements))
        ) {
            throw new OneElementExpectedException();
        }

        if (false === $this->isOneOrNullFnExecuted) {
            $this->isOneOrNullFnExecuted = true;
            $this->first = ($this->oneOrExceptionFn)();

            $this->loadDataFromOneOrException();
        }

        return $this->first ?? throw new OneElementExpectedException();
    }

    private function loadDataFromElements(): void
    {
        if (null === $this->elements) {
            throw new \RuntimeException('elements function not executed');
        }

        $this->first ??= self::_first($this->elements);
        $this->isFirstFnExecuted = true;

        if (true === empty($this->elements)) {
            $this->count = 0;
        } elseif (null !== $this->maxElements) {
            $numberOfElements = count($this->elements);

            if ($this->maxElements > $numberOfElements) {
                $this->count = $numberOfElements;
            }
        }
    }

    private function loadDataFromFirst(): void
    {
        if (false === $this->isFirstFnExecuted) {
            throw new \RuntimeException('first function not executed');
        }

        if (null === $this->first) {
            $this->count = 0;
            $this->elements ??= [];
            $this->isOneOrNullFnExecuted = true;
        } elseif (1 === $this->count) {
            $this->isOneOrNullFnExecuted = true;
            $this->elements ??= [$this->first];
        }
    }

    private function loadDataFromOneOrException(): void
    {
        if (false === $this->isOneOrNullFnExecuted) {
            throw new \RuntimeException('oneOrNull function not executed');
        }

        $elements = null === $this->first ? [] : [$this->first];

        $this->isFirstFnExecuted = true;
        $this->count = count($elements);
        $this->elements ??= $elements;
    }

    private function loadDataFromCount(): void
    {
        if (null === $this->count) {
            throw new \RuntimeException('count function not executed');
        }

        if (0 === $this->count) {
            $this->isFirstFnExecuted = true;
            $this->isOneOrNullFnExecuted = true;
            $this->elements ??= [];

            return;
        }

        if (1 === $this->count && null !== $this->first) {
            $this->isOneOrNullFnExecuted = true;
            $this->elements ??= [$this->first];
        }
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