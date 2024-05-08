<?php

namespace Oscmarb\Criteria\Order;

final class CriteriaOrderByValueCanNotBeEmptyException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Criteria order value cannot be empty');
    }
}