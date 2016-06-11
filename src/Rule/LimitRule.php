<?php

namespace Dgame\Filter\Rule;

use Dgame\Filter\Exception\InvalidLimitException;

/**
 * Class LimitRule
 * @package Dgame\Filter\Rule
 */
final class LimitRule implements Rule
{
    /**
     * @var null|TypeRule
     */
    private $rule = null;
    /**
     * @var int
     */
    private $limit = 0;

    /**
     * LimitRule constructor.
     *
     * @param TypeRule $rule
     * @param int      $limit
     */
    public function __construct(TypeRule $rule, int $limit)
    {
        $this->rule  = $rule;
        $this->limit = $limit;
    }

    /**
     * @param $value
     *
     * @return bool
     * @throws InvalidLimitException
     */
    public function verify($value) : bool
    {
        if (!$this->rule->verify($value)) {
            return false;
        }
        
        if (is_string($value)) {
            $len = strlen($value);

            return $len === $this->limit;
        }

        if (is_numeric($value)) {
            return $value === $this->limit;
        }

        throw new InvalidLimitException();
    }
}