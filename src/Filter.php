<?php

namespace Dgame\Filter;

use Dgame\Filter\Rule\Rules;

/**
 * Class Filter
 * @package Dgame\Filter
 */
final class Filter
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Filter constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param callable $callback
     *
     * @return Filter
     */
    public function map(callable $callback): Filter
    {
        $this->data = array_map($callback, $this->data);

        return $this;
    }

    /**
     * @param array $callbacks
     *
     * @return Filter
     */
    public function apply(array $callbacks): Filter
    {
        foreach ($callbacks as $key => $callback) {
            if (array_key_exists($key, $this->data)) {
                $this->data[$key] = call_user_func($callback, $this->data[$key]);
            }
        }

        return $this;
    }

    /**
     * @param array $keys
     *
     * @return Filter
     */
    public function allowOnly(array $keys): Filter
    {
        return $this->filterBy(function($key) use ($keys) {
            return in_array($key, $keys);
        },
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * @param array $defaults
     *
     * @return Filter
     */
    public function applyDefaults(array $defaults): Filter
    {
        foreach ($defaults as $key => $value) {
            if (!array_key_exists($key, $this->data) || empty($this->data[$key])) {
                $this->data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function filter()
    {
        $this->data = array_filter($this->data);

        return $this;
    }

    /**
     * @param callable $callback
     * @param int      $flag
     *
     * @return Filter
     */
    public function filterBy(callable $callback, int $flag = ARRAY_FILTER_USE_BOTH): Filter
    {
        $this->data = array_filter($this->data, $callback, $flag);

        return $this;
    }

    /**
     * @param array $rules
     *
     * @return Filter
     */
    public function filterByRules(array $rules): Filter
    {
        $this->data = Rules::Create($rules)->apply($this->data);

        return $this;
    }

    /**
     * @param array $matches
     *
     * @return Filter
     */
    public function filterByPattern(array $matches): Filter
    {
        foreach ($matches as $key => $pattern) {
            if (array_key_exists($key, $this->data) && !preg_match($pattern, $this->data[$key])) {
                unset($this->data[$key]);
            }
        }

        return $this;
    }
}