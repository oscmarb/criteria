<?php

namespace Oscmarb\Criteria\Result;

final class OneElementExpectedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('One element expected exception');
    }
}