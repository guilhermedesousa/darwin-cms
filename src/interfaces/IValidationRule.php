<?php

namespace src\interfaces;

interface IValidationRule
{
    public function validateRule($value);

    public function getErrorMessage();
}