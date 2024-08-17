<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Dictionary;
use Vekas\Translation\JsonDictionaryFactory;
use Vekas\Translation\JsonFileLangHandler;
use Vekas\Translation\Interfaces\LangLoaderInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\LanguageValidatorFactory;
use Vekas\Translation\LanguageValidators\EnglishValidator;

#[CoversClass(Dictionary::class)]
class DictionaryTest extends TestCase {
    private Dictionary $dictionary ;
    function setUp(): void {

        // $jsonFileLangHandler = $this->createMock(JsonFileLangHandler::class);
        // $jsonFileLangHandler->method("getItem")->willReturn("translated");
        // $jsonFileLangHandler->method("getSourceLang")->willReturn("en");
        // $jsonFileLangHandler->method("getTargetLang")->willReturn("ar");

        $jsonFileLangHandler = new JsonFileLangHandler(__DIR__."/dics","2","en","ar");

        $dictionary = new Dictionary($jsonFileLangHandler,[LanguageValidatorFactory::class,"getValidatorByCode"]);

        $this->dictionary = $dictionary;
    }

    
    function testCreateDictionary() {
        $this->assertInstanceOf(Dictionary::class,$this->dictionary);
    }


    function testGetLanguageService() {
        $lservice = $this->dictionary->getLanguageService();
        $this->assertNotNull($lservice);
    }
    
    function testGetSourceLanguage() {
        $sourceLang = $this->dictionary->getLanguageService()->getSourceLang();
        $this->assertNotNull($sourceLang);
    }


    function testTranslateWord() {
        $translated = $this->dictionary->findOpposit("thing");
        $this->assertNotNull($translated);
    }

    
    function testAddNewItem() {
        /** @var MockObject */
        $languageService =  $this->dictionary->getLanguageService();

        $this->dictionary->addItem("mama","امي");

        $word = $this->dictionary->findOpposit("mama");

        $this->assertNotNull($word);

        $this->dictionary->removeItem("mama");
    }

    function testThrowExceptionWhenOtherLanguageSet() {
        
        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->findOpposit("مرحبا بالعالم");

        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->removeItem("مرحبا بالعالم");

        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->addItem("مرحبا بالعالم","hello world");

    }

    function testThrowInvalidLanguageValueException() {
        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->findOpposit("مرحبا");
    }

    function testSwapLanguagesAndValidateThemAutomaticly() {
        $this->dictionary->switchLanguages();
        $translated = $this->dictionary->findOpposit("شيء");
        $this->assertSame("thing",$translated);
    }

    function testValidateTheOtherLanguageWhenSwitching() {
        $this->dictionary->switchLanguages();
        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->findOpposit("something");
    }
    
}