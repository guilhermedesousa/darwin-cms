<?php

class PasswordValidator
{
    private string $password;
    private string $passwordLength;
    private PasswordRules $rules;

    public function __construct($password)
    {
        $this->password = $password;
        $this->passwordLength = strlen($password);
        $this->rules = new PasswordRules();
    }

    public function checkMinCharacters(): bool
    {
        return $this->passwordLength >= $this->rules->minCharacters;
    }

    public function checkMaxCharacters(): bool
    {
        return $this->passwordLength <= $this->rules->maxCharacters;
    }

    public function checkSpecialCharacters(): bool
    {
        return preg_match($this->rules->specialCharacters, $this->password);
    }
}