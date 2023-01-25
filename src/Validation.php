<?php

namespace src;

use src\interfaces\IValidationRule;

class Validation
{
    private array $rules;
    private array $errorMessages = [];

    public function __construct()
    {
        $this->rules = [];
    }

    public function addRule(IValidationRule $rule): Validation
    {
        $this->rules[] = $rule;
        return $this;
    }

    public function validate($value): bool
    {
        foreach ($this->rules as $rule) {
            $ruleValidation = $rule->validateRule($value);
            if (!$ruleValidation) {
                $this->errorMessages[] = $rule->getErrorMessage();
                return false;
            }
        }

        return true;
    }

    public function getAllErrorMessages(): array
    {
        return $this->errorMessages;
    }

    public function cleanRules(): Validation
    {
        $this->rules = [];
        return $this;
    }
}