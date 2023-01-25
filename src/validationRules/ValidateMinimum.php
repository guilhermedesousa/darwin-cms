<?php

namespace src\validationRules;

use src\interfaces\IValidationRule;

class ValidateMinimum implements IValidationRule
{
    private int $minimum;

    public function __construct($minimum)
    {
        $this->minimum = $minimum;
    }

    public function validateRule($value): bool
    {
        return strlen($value) >= $this->minimum;
    }

    public function getErrorMessage(): string
    {
        return "Minimum value is under $this->minimum";
    }
}