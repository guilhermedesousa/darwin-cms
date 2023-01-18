<?php

interface IValidationRule
{
    public function validateRule($value);

    public function getErrorMessage();
}