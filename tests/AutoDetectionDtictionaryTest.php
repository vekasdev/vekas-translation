<?php

namespace Vekas\Translation;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Exceptions\IllegalStateException;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;

#[CoversClass(AutoDetectionDictionary::class)]
class AutoDetectionDtictionaryTest extends TestCase {
    private AutoDetectionDictionary $autoDictionary;
    function setUp(): void{

        JsonLanguageServiceFactory::setDirectory(__DIR__."/dics");
        JsonLanguageServiceFactory::setSeparator("2");

        $this->autoDictionary = new AutoDetectionDictionary(
            JsonLanguageServiceFactory::class,
            new LanguageDetectorFactory()
        );
    }

    function testCreateDictionary() {
        $this->assertNotNull($this->autoDictionary);
    }

    function testDetectSourceLanguage() {
        $this->autoDictionary->detectSourceLanguage("english");
        $sourceLang = $this->autoDictionary->getSourceLang();
        $this->assertEquals("en",$sourceLang);
    }

    function testGetLanguageService() {
        $this->autoDictionary->setTargetLang("ar");

        // set the source lang
        $ref = new \ReflectionObject($this->autoDictionary);
        $method = $ref->getMethod("setSourceLang");
        $method->setAccessible(true);
        $method->invoke($this->autoDictionary,"en");

        $languageService = $this->autoDictionary->getLanguageService();

        $this->assertNotNull($languageService);
        $this->assertInstanceOf(JsonFileLangHandler::class,$languageService);
        $this->assertInstanceOf(JsonFileLangHandler::class,$languageService);
        $this->assertEquals("en",$languageService->getSourceLang());
        $this->assertEquals("ar",$languageService->getTargetLang());
    }

    function testTranslateWord() {
        $this->autoDictionary->setTargetLang("ar");
        $result = $this->autoDictionary->findOpposit("bird");
        $this->assertEquals("طائر",$result);
    }

    function testRegisteringMultipleLanguageServiceObjects() {
        $this->autoDictionary->setTargetLang("ar");

        $res1 = $this->autoDictionary->findOpposit("bird");
        $res2 = $this->autoDictionary->findOpposit("pájaro");
        
        $this->assertEquals("طائر",$res1);
        $this->assertEquals("طائر",$res2);

        
        $services = $this->autoDictionary->getLoadedLanguageServices();

        $this->assertEquals(false, $services["enToar"]->isSwitched());
        $this->assertEquals(true, $services["esToar"]->isSwitched());
        
        $this->assertEquals("طائر",$res2);

        // test number of servieces still 2
        $res3 = $this->autoDictionary->findOpposit("pájaro");
        $services = $this->autoDictionary->getLoadedLanguageServices();

        $this->assertEquals(2,count($services));
    }

    function testGetExceptionWhenPassingNotRegisteredLanguage(){
        $this->autoDictionary->setTargetLang("ar");
        $this->expectException(InvalidLanguageValueException::class);
        $this->autoDictionary->findOpposit("单词");
    }

    function testGetNullWhenWordNotFound() {
        $this->autoDictionary->setTargetLang("ar");
        $res = $this->autoDictionary->findOpposit("symfony");
        $this->assertNull($res);
    }

    function testSwitchLanguageOfCurrentServiceRegistered() {
        $this->autoDictionary->setTargetLang("ar");
        $this->autoDictionary->findOpposit("symfony"); // set source to en
        
        $this->autoDictionary->switchLanguage(); // target became en

        $this->assertSame("en",$this->autoDictionary->getTargetLang());
        $res = $this->autoDictionary->findOpposit("طائر");
        $this->assertSame("bird",$res);
    }

    function testWhenTheSourceAndTargetAreSame() {
        $this->autoDictionary->setTargetLang("en");
        $this->expectException(InvalidLanguageValueException::class);
        $this->autoDictionary->findOpposit("symfony"); // set source to en
    }


    function testExpectThrowingIllegalStateException() {
        $this->autoDictionary->setTargetLang("en");
        $this->expectException(IllegalStateException::class);
        $this->autoDictionary->switchLanguage();
    }


}
