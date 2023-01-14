<?php

class ValidateMinimum
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
}