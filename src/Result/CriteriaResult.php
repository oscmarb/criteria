<?php

namespace Oscmarb\Criteria\Result;

/**
 * @template T
 */
interface CriteriaResult
{
    /**
     * Gets count of all criteria results that exists, not only recovered elements.
     */
    public function count(): int;

    /**
     * Checks whether the result is empty (contains no elements).
     */
    public function isEmpty(): bool;

    /**
     * Gets all recovered elements.
     *
     * @return T[]
     */
    public function elements(): array;

    /**
     * Returns the first element.
     *
     * @return T|null
     */
    public function first();

    /**
     * Returns one element if only it exists; otherwise it throws an exception.
     *
     * @return T
     */
    public function oneOrException();
}