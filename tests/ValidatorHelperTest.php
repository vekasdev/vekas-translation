<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\ValidatorHelper;

#[CoversClass(ValidatorHelper::class)]
class ValidatorHelperTest extends TestCase {
    function testGetLanguagesCodes() {
        $codes = ValidatorHelper::getLanguageCodes();
        $this->assertGreaterThan(0,count($codes));
    }
}