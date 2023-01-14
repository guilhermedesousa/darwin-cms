<?php

class Validation
{
    private array $rules;

    public function __construct()
    {
        $this->rules = [];
    }

    public function addRule($rule): Validation
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function validate($value): bool
    {
        foreach ($this->rules as $rule) {
            $ruleValidation = $rule->validateRule($value);
            if (!$ruleValidation) {
                return false;
            }
        }

        return true;
    }
}