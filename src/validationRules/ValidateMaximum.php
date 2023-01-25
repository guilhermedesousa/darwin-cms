<?php

namespace src\validationRules;

use src\interfaces\IValidationRule;

class ValidateMaximum implements IValidationRule
{
    private int $maximum;

    public function __construct($maximum)
    {
        $this->maximum = $maximum;
    }

    public function validateRule($value): bool
    {
        return strlen($value) <= $this->maximum;
    }

    public function getErrorMessage(): string
    {
        return "Maximum value is over $this->maximum";
    }
}