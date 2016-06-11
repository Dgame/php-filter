<?php

namespace Dgame\Filter\Rule;

use Dgame\Filter\Exception\InvalidTypeException;

/**
 * Class TypeRule
 * @package Dgame\Filter\Rule
 */
final class TypeRule implements Rule
{
    const TYPE_PATTERN = [
        '#numeric#'                       => 'is_numeric',
        '#int(?:eger)?#'                  => 'is_int',
        '#(?:float|double|real|decimal)#' => 'is_float',
        '#string#'                        => 'is_string',
        '#bool(?:ean)?#'                  => 'is_bool',
        '#(?:object|class)#'              => 'is_object',
        '#array#'                         => 'is_array'
    ];

    /**
     * @var callable|null
     */
    private $function = null;

    /**
     * TypeRule constructor.
     *
     * @param string $type
     */
    public function __construct(string $type)
    {
        foreach (self::TYPE_PATTERN as $pattern => $function) {
            if (preg_match($pattern, $type)) {
                $this->function = $function;
                break;
            }
        }

        if ($this->function === null) {
            throw new InvalidTypeException($type);
        }
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function verify($value) : bool
    {
        return call_user_func($this->function, $value);
    }
}