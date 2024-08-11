<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageValidators\EnglishValidator;

#[CoversClass(EnglishValidator::class)]
class EnglishValidatorTest extends TestCase {
    private EnglishValidator $validator;
    function setUp(): void {
        $this->validator = new EnglishValidator();
    }
} 