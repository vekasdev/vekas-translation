<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\LanguageDetector;
use Vekas\Translation\LanguageDetectorFactory;

#[CoversClass(LanguageDetectorFactory::class)]
class LanguageDetectorFactoryTest extends TestCase {
    private  LanguageDetectorFactory $languageDetectorFactory ;
    function setUp(): void {
        $this->languageDetectorFactory = new LanguageDetectorFactory();
    }

    function testCreateLanguageDetectorInstance() {
        $ld = $this->languageDetectorFactory->make();
        $this->assertInstanceOf(LanguageDetector::class,$ld);
    }
}