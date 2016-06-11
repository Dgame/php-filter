<?php

namespace Dgame\Filter\Rule;

/**
 * Class RuleFactory
 * @package Dgame\Filter\Rule
 */
final class RuleFactory
{
    /**
     * @param string $class
     * @param array  $matches
     *
     * @return Rule
     */
    public static function Make(string $class, array $matches) : Rule
    {
        array_shift($matches); // $matches[0] contains the whole string; we don't need that

        $rule = new TypeRule(array_shift($matches));
        if (empty($matches)) {
            return $rule;
        }

        array_unshift($matches, $rule);

        $ref = new \ReflectionClass($class);

        return $ref->newInstanceArgs($matches);
    }
}