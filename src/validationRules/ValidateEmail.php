<?php

namespace src\validationRules;

use src\interfaces\IValidationRule;

class ValidateEmail implements IValidationRule
{
    public function validateRule($value): bool
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    public function getErrorMessage(): string
    {
        return "Email format is not correct.";
    }
}