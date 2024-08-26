<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Dictionary;
use Vekas\Translation\JsonDictionaryFactory;
use Vekas\Translation\VekasTranslator;

#[CoversClass(VekasTranslator::class)]
class VekasTranslatorTest extends TestCase {
    private VekasTranslator $vekasTranslator ;
    function setUp(): void {
        $dictionary =  JsonDictionaryFactory::getDictionery(__DIR__."/dics","en","ar");
        $this->vekasTranslator = new VekasTranslator($dictionary);
    }

    function testCreateVekasTranslator() {
        $this->assertInstanceOf(VekasTranslator::class , $this->vekasTranslator);
    }

    function testGettingCurrentStateOfDictionary(){
        $state = $this->vekasTranslator->getLanguagePair();
        $this->assertSame(
            [
                "target" => "ar",
                "source" => "en"
            ],
            $state
        );
    }

    function testSwitchLanguages() {
        $this->vekasTranslator->switchLanguages();
        $state = $this->vekasTranslator->getLanguagePair();
        $this->assertSame(
            [
                "target" => "en",
                "source" => "ar"
            ],
            $state
        );
    }

    function testTranslatePhrase() {
        $dictionary = $this->vekasTranslator->getDictionary();
        $dictionary->addItem("hello","مرحبا");
        $dictionary->addItem("world","العالم");

        $translated = $this->vekasTranslator->translate("hello world");
        
        $this->assertSame("مرحبا العالم",$translated) ; // assertion
        
        $dictionary->removeItem("hello");
        $dictionary->removeItem("world");

    }


}