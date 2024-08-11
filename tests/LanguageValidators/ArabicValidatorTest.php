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
}