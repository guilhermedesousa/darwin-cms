<?php

namespace src\validationRules;

use src\interfaces\IValidationRule;

class ValidateSpecialCharacter implements IValidationRule
{
    private string $rule;

    public function __construct($rule = "/[\'^£$%&*()}{@#~?><>,|=_+¬-]/")
    {
        $this->rule = $rule;
    }

    public function validateRule($value): bool
    {
        return preg_match($this->rule, $value);
    }

    public function getErrorMessage()
    {
        return "Special character is not found";
    }
}