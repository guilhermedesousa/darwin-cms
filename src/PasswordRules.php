<?php

namespace src;

class PasswordRules
{
    public int $minCharacters;
    public int $maxCharacters;
    public string $specialCharacters;

    public function __construct()
    {
        $this->minCharacters = 6;
        $this->maxCharacters = 20;
        $this->specialCharacters = '/[\'^£$%&*()}{@#~?><>,|=_+¬-]/';
    }
}