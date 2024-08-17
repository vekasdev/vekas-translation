<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Dictionary;
use Vekas\Translation\Exceptions\FileNotExistException;
use Vekas\Translation\JsonDictionaryFactory;
use Vekas\Translation\NullDictionary;

#[CoversClass(JsonDictionaryFactory::class)]
class JsonDictionaryFactoryTest extends TestCase {
    function setUp(): void {

    }

    function testGetDictionaryByJsonDictionaryFactory() {
        $dictionary = JsonDictionaryFactory::getDictionery(__DIR__."/dics","en","ar");
        $this->assertInstanceOf(Dictionary::class,$dictionary);
    }

    function testGetNotExistDictionary() {
        $this->expectException(FileNotExistException::class);
        JsonDictionaryFactory::getDictionery(__DIR__."/dics","eu","ar");
    }
    
    function testGetNullDictionaryWhenAskForSimilarLanguagePair() {
        $dictionary = JsonDictionaryFactory::getDictionery(__DIR__."/dics","en","en");
        $this->assertInstanceOf(NullDictionary::class,$dictionary);
    }

}