<?php declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use src\{Validation, validationRules\ValidateEmail};

require_once 'src/interfaces/IValidationRule.php';
require_once 'src/Validation.php';
require_once 'src/validationRules/ValidateEmail.php';

final class ValidationTest extends TestCase
{
    public function testValidationEmail(): void
    {
        $validationClass = new Validation();
        $validationClass->addRule(new ValidateEmail());

        $this->assertFalse($validationClass->validate('1234'));
        $this->assertTrue($validationClass->validate('test@email.com'));
    }
}
