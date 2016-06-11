<?php

namespace Dgame\Filter\Exception;

final class InvalidTypeException extends \Exception
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('Invalid Type: %s', $type));
    }
}