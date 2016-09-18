<?php

namespace Dgame\Filter\Rule;

/**
 * Class Rules
 * @package Dgame\Filter\Rule
 */
final class Rules
{
    const RULE_PATTERN = [
        RangeRule::class => '#^([a-z]+.*?)\((\d+)\s*,\s*(\d+)\)$#',
        LimitRule::class => '#^([a-z]+.*?)\((\d+)\)$#',
        MatchRule::class => '#^([a-z]+.*?)\((.+?)\)$#',
        TypeRule::class  => '#^([a-z]+.*?)$#'
    ];

    /**
     * @var Rule[]
     */
    private $rules = [];

    /**
     * @param array $rules
     *
     * @return Rules
     */
    public static function Create(array $rules): Rules
    {
        return new self($rules);
    }

    /**
     * Rules constructor.
     *
     * @param array $rules
     */
    public function __construct(array $rules)
    {
        $this->process($rules);
    }

    /**
     * @param array $rules
     */
    private function process(array $rules)
    {
        foreach ($rules as $key => $rule) {
            foreach (self::RULE_PATTERN as $class => $pattern) {
                if (preg_match($pattern, $rule, $matches)) {
                    $this->rules[$key] = RuleFactory::Make($class, $matches);
                    break;
                }
            }
        }
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function apply(array $data): array
    {
        foreach ($data as $key => $value) {
            if (array_key_exists($key, $this->rules) && !$this->rules[$key]->verify($value)) {
                unset($data[$key]);
            }
        }

        return $data;
    }
}