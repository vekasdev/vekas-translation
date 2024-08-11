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

        $jsonFileLangHandler = $this->createMock(JsonFileLangHandler::class);
        $jsonFileLangHandler->method("getItem")->willReturn("translated");
        $languageValidator = (new LanguageValidatorFactory)->getValidator(EnglishValidator::class);

        $dictionary = new Dictionary($jsonFileLangHandler,$languageValidator);

        $this->dictionary = $dictionary;
    }

    
    function testCreateDictionary() {
        $this->assertInstanceOf(Dictionary::class,$this->dictionary);
    }

    function testTranslateWord() {
        $translated = $this->dictionary->findOpposit("translated");
        $this->assertNotNull($translated);
    }


    function testAddNewItem() {
        /** @var MockObject */
        $languageService =  $this->dictionary->getLanguageService();
        
        $languageService->expects($this->once())
            ->method("addItem");

        $this->dictionary->addItem("mama","امي");
    }

    function testThrowExceptionWhenOtherLanguageSet() {
        
        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->findOpposit("مرحبا بالعالم");

        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->removeItem("مرحبا بالعالم");

        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->addItem("مرحبا بالعالم","hello world");

    }

}