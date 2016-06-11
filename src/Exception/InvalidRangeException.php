<?php

namespace Dgame\Filter\Exception;

final class InvalidRangeException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid Range');
    }
}