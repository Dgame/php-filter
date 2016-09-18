<?php

namespace Dgame\Filter\Rule;

use Dgame\Filter\Exception\InvalidRangeException;

/**
 * Class RangeRule
 * @package Dgame\Filter\Rule
 */
final class RangeRule implements Rule
{
    /**
     * @var TypeRule
     */
    private $rule;
    /**
     * @var int
     */
    private $min = 0;
    /**
     * @var int
     */
    private $max = 0;

    /**
     * RangeRule constructor.
     *
     * @param TypeRule $rule
     * @param int      $min
     * @param int      $max
     */
    public function __construct(TypeRule $rule, int $min, int $max)
    {
        $this->rule = $rule;
        $this->min  = $min;
        $this->max  = $max;
    }

    /**
     * @param $value
     *
     * @return bool
     * @throws InvalidRangeException
     */
    public function verify($value): bool
    {
        if (!$this->rule->verify($value)) {
            return false;
        }
        
        if (is_string($value)) {
            $len = strlen($value);

            return $len >= $this->min && $len <= $this->max;
        }

        if (is_numeric($value)) {
            return $value >= $this->min && $value <= $this->max;
        }

        throw new InvalidRangeException();
    }
}