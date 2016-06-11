<?php

namespace Dgame\Filter\Rule;

/**
 * Interface Rule
 * @package Dgame\Filter\Rule
 */
interface Rule
{
    /**
     * @param $value
     *
     * @return bool
     */
    public function verify($value) : bool;
}