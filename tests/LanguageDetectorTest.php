<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageDetector;
use Vekas\Translation\ValidatorsLoader;

#[CoversClass(LanguageDetector::class)]
class LanguageDetectorTest extends TestCase {
    private LanguageDetector $languageDetector;
    function setUp(): void {
        $ld = new LanguageDetector();
        $loader = new ValidatorsLoader();
        $ld = $loader->load($ld);
        $this->languageDetector = $ld;
    }

    function testCreateLanguageDetector() {
        $this->assertInstanceOf(LanguageDetector::class,$this->languageDetector);
    }


    function testGetValidators() {
        $validators = $this->languageDetector->getValidators();
        $this->assertCount(3,$validators);
    }
    
    // #[Group("skip")]
    function testDetectEnglishText() {
        $result = $this->languageDetector->detect("hello world");
        $this->assertSame("en",$result);
    }

}