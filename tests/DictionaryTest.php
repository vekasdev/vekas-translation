<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;
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
use Vekas\Translation\LanguageDetectorFactory;

#[CoversClass(Dictionary::class)]
class DictionaryTest extends TestCase {
    private Dictionary $dictionary ;
    function setUp(): void {

        // $jsonFileLangHandler = $this->createMock(JsonFileLangHandler::class);
        // $jsonFileLangHandler->method("getItem")->willReturn("translated");
        // $jsonFileLangHandler->method("getSourceLang")->willReturn("en");
        // $jsonFileLangHandler->method("getTargetLang")->willReturn("ar");

        $jsonFileLangHandler = new JsonFileLangHandler(__DIR__."/dics","2","en","ar");

        LanguageValidatorFactory::loadValidators();

        $languageDetectorFactory = new LanguageDetectorFactory();

        $dictionary = new Dictionary(
            $jsonFileLangHandler,
            [LanguageValidatorFactory::class,"getValidatorByCode"],
            $languageDetectorFactory
        );

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
        $this->dictionary->switchLanguage();
        $translated = $this->dictionary->findOpposit("شيء");
        $this->assertSame("thing",$translated);
    }

    function testValidateTheOtherLanguageWhenSwitching() {
        $this->dictionary->switchLanguage();
        $this->expectException(InvalidLanguageValueException::class);
        $this->dictionary->findOpposit("something");
    }
    
    function testDetectTheWrongLanguageByException() {

        // source ar
        $this->dictionary->switchLanguage();
        try {
            $this->dictionary->findOpposit("something");
        } catch (InvalidLanguageValueException $e) {
            $detectedLanguage =  $e->getDetectedLanguage();
            $this->assertSame("en",$detectedLanguage);
        }

        // source => en
        $this->dictionary->switchLanguage();
        try {
            $this->dictionary->findOpposit("مرحبا يا اصدقاء");
        } catch (InvalidLanguageValueException $e) {
            $detectedLanguage =  $e->getDetectedLanguage();
            $this->assertSame("ar",$detectedLanguage);
        }
        
    }

    function testCheckOfNonCharsLetters() {
        $result = $this->dictionary->isNonChar(".");
        $this->assertTrue($result);
    }
    
    function testTheStateOfSwitchingLanguagesDynamiclySet() {
        $dictionary = $this->getSwitchedJsonDictionary();
        $this->assertTrue($dictionary->isSwitched());
    }
    

    function getSwitchedJsonDictionary() {
        $jsonFileLangHandler = new JsonFileLangHandler(__DIR__."/dics","2","ar","en");

        LanguageValidatorFactory::loadValidators();

        $languageDetectorFactory = new LanguageDetectorFactory();

        return new Dictionary(
            $jsonFileLangHandler,
            [LanguageValidatorFactory::class,"getValidatorByCode"],
            $languageDetectorFactory
        );
    }
}