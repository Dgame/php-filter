<?php

namespace Dgame\Filter\Exception;

final class InvalidLimitException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid Limit');
    }
}
