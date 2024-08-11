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

    function testValidateDiffirentPhrases() {
        $this->assertTrue(
            $this->validator->validate("Ella va a la tienda ayer.")
        );

        $this->assertTrue(
            $this->validator->validate("Reciví una carta hoy.")
        );

        $this->assertTrue(
            $this->validator->validate("La abitación era muy cómoda.")
        );
        $this->assertTrue(
            $this->validator->validate("Él dijo “Voy a llegar pronto.”")
        );   
        $this->assertTrue(
            $this->validator->validate("¿Qué hora es")
        );         
        
    }
} 