<?php

namespace src\validationRules;

use src\interfaces\IValidationRule;

class ValidateNoEmptySpaces implements IValidationRule
{
    public function validateRule($value): bool
    {
        if (strpos($value, ' ') === false) {
            return true;
        }
        return false;
     }

    public function getErrorMessage(): string
    {
        return "No empty spaces allowed.";
     }
}