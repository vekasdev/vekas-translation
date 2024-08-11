<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageValidators\EnglishValidator;
use Vekas\Translation\LanguageValidators\SpanishValidator;

#[CoversClass(EnglishValidator::class)]
class SpanishValidatorTest extends TestCase {
    private SpanishValidator $validator;
    function setUp(): void {
        $this->validator = new SpanishValidator();
    }
} 