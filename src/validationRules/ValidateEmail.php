<?php

class ValidateEmail
{
    private int $filter;

    public function __construct($filter = FILTER_VALIDATE_EMAIL)
    {
        $this->filter = $filter;
    }

    public function validateRule($value): bool
    {
        if (!filter_var($value, $this->filter)) {
            return false;
        }
        return true;
    }
}