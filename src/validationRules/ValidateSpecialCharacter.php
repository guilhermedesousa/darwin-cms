<?php

class ValidateSpecialCharacter
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
}