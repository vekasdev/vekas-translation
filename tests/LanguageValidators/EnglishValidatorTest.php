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

    function testValidateWithDiffrentPhrases() {
        $this->assertTrue(
            $this->validator->validate("hello what exactly do you want ?")
        );

        $this->assertTrue(
            $this->validator->validate("hello world ! ")
        );

        $this->assertTrue(
            $this->validator->validate("She, because she was late, missed the bus")
        );
        $this->assertTrue(
            $this->validator->validate("He said “I’'ll be there soon.”")
        );

    }

    function testValidateSpellingPhrases() {
        $this->assertTrue(
            $this->validator->validate("he’s a genious")
        );
        $this->assertTrue(
            $this->validator->validate("Lets eat grandma!")
        );

        
    }
    
} 