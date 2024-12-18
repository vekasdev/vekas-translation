<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageValidators\ChineseValidator;

#[CoversClass(ChineseValidator::class)]
class ChineseValidatorTest extends TestCase {
    private ChineseValidator $chineseValidator;
    function setUp(): void {
        $this->chineseValidator = new ChineseValidator;
    }

    function testValidateChineseWord() {
        $this->assertTrue($this->chineseValidator->validate("你好"));
        $this->assertFalse($this->chineseValidator->validate("hello"));
    }

    function testValidateChinesePhraseWithSpecialChars() {
        $this->assertTrue($this->chineseValidator->validate("你好 你好./@"));
    }


}