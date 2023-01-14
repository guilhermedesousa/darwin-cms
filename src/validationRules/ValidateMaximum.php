<?php

class ValidateMaximum
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
}