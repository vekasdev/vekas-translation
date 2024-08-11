<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageValidators\ArabicValidator;

#[CoversClass(ArabicValidator::class)]
class ArabicValidatorTest extends TestCase {
    private ArabicValidator $validator;
    function setUp(): void {
        $this->validator = new ArabicValidator();
    }

    function testValidateOneLine() {
        $this->assertTrue(
            $this->validator->validate("مرحبا بالعالم")
        );
    }

    function testValidateNewLine() {
        $this->assertTrue(
            $this->validator->validate("مرحبا بالعالم \n")
        );
    }

    function testValidateWithQuerySign() {
        $this->assertTrue(
            $this->validator->validate("ماذا تريد ؟!")
        );
    }
    
}