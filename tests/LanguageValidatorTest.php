<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageValidator;
use Vekas\Translation\LanguageValidatorFactory;
use Vekas\Translation\LanguageValidators\EnglishValidator;


#[CoversClass(LanguageValidator::class)]
class LanguageValidatorTest extends TestCase {
    private LanguageValidator $languageValidator;

    function setUp(): void {
        $factory = new LanguageValidatorFactory;
        $enValid = $factory->getValidator(EnglishValidator::class);
        $this->languageValidator= $enValid;
    }

    function testCreateLanguageValidator() {
        $this->assertInstanceOf(LanguageValidator::class,$this->languageValidator);
    }

    function testThrowExceptionWhenSpecifyNonImplementingInterfaceClass() {
        $factory = new LanguageValidatorFactory;
        $this->expectException(InvalidArgumentException::class);
        $enValid = $factory->getValidator(LanguageValidatorTest::class);
        $this->languageValidator= $enValid;
    }

    function testValidateStringIfItEnglish() {
        $result = $this->languageValidator->validate("Hello World");
        $this->assertTrue($result);
    }

    function testValidateStringIfItNotEnglish() {
        $result = $this->languageValidator->validate("اهلاً وسهلاً");
        $this->assertNotTrue($result);
    }
}