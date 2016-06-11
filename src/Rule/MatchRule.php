<?php

namespace Dgame\Filter\Rule;

/**
 * Class MatchRule
 * @package Dgame\Filter\Rule
 */
final class MatchRule implements Rule
{
    /**
     * @var null|TypeRule
     */
    private $rule = null;
    /**
     * @var null|string
     */
    private $pattern = null;

    /**
     * MatchRule constructor.
     *
     * @param TypeRule $rule
     * @param string   $pattern
     */
    public function __construct(TypeRule $rule, string $pattern)
    {
        $this->rule    = $rule;
        $this->pattern = sprintf('#%s#', $pattern);
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function verify($value) : bool
    {
        return $this->rule->verify($value) && preg_match($this->pattern, $value) === 1;
    }
}