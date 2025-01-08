<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\JsonFileLangHandler;
use Vekas\Translation\JsonLanguageHelper;
use Vekas\Translation\JsonLanguageRepository;
use Vekas\Translation\JsonLanguageServiceFactory;
use Vekas\Translation\ValidatorHelper;

#[CoversClass(JsonFileLangHandler::class)]
class JsonFIleLangHandlerTest extends TestCase {
    private JsonFileLangHandler $jsonFileLangHandler;
    
    function setUp(): void {
        $this->jsonFileLangHandler = $this->getJsonLanguageService("en","ar");
    }
    function testThrowExceptionWhenTryAddExistedItem() {
        $this->jsonFileLangHandler->setData([
            "bee"=>"نحلة"
        ]);

        $this->expectException(ItemAlreadyExistException::class);
        
        $this->jsonFileLangHandler->addItem("bee","نحلة");
    }


    function testGetFileNameByPath() {
        $result = $this-> jsonFileLangHandler->getFileName("myage/mainfolder/index.php");
        $this->assertSame("index.php",$result);
    }


    function testLanguageNotSwappedByDefault() {
        $this->assertNotTrue( $this->jsonFileLangHandler->isSwapped());
        $this->assertSame("en",$this->jsonFileLangHandler->getSourceLang());
        $this->assertSame("ar",$this->jsonFileLangHandler->getTargetLang());
    }

    function testSwapingLanguage() {
        $this->jsonFileLangHandler->swapLanguages();
        $this->jsonFileLangHandler->swapState();
        
        $this->assertTrue( $this->jsonFileLangHandler->isSwapped());
        $this->assertSame("ar",$this->jsonFileLangHandler->getSourceLang());
        $this->assertSame("en",$this->jsonFileLangHandler->getTargetLang());
    }

    function testSwappingTwice() {
        $this->jsonFileLangHandler->swapLanguages();
        $this->jsonFileLangHandler->swapLanguages();
        $this->assertNotTrue( $this->jsonFileLangHandler->isSwapped());
        $this->assertSame("en",$this->jsonFileLangHandler->getSourceLang());
        $this->assertSame("ar",$this->jsonFileLangHandler->getTargetLang());
    }

    function testGetPathWhenSwapping() {
        // swap one
        $this->jsonFileLangHandler->swapLanguages();
        $fileName = basename($this->jsonFileLangHandler->getFullPath());
        $this->assertSame("ar2en.json",$fileName);

        // swap two
        $this->jsonFileLangHandler->swapLanguages();
        $fileName = basename($this->jsonFileLangHandler->getFullPath());
        $this->assertSame("en2ar.json",$fileName);
    }

    
    function testLoadSwappedVersionOfJsonFileHandler() {

        $fileHandler = $this->loadSwappedVersionOfJsonFileHandler();

        $this->assertInstanceOf(JsonFileLangHandler::class,$fileHandler);
        $this->assertTrue($fileHandler->isSwapped());
    }



    function testAddEntryInSwappedMode() {
        $handler = $this->loadSwappedVersionOfJsonFileHandler();
        $itemToAdd = "شيء";
        
        try {
            $handler->addItem($itemToAdd,"thing");
        } catch (ItemAlreadyExistException $e ) {

        }

        $this->assertTrue(isset($handler->getData()["شيء"]));
        $this->assertSame("thing",$handler->getData()["شيء"]);
    }



    function testAddAndRemoveItem() {
        $this->jsonFileLangHandler->setApproximityFeature(false);
        $this->jsonFileLangHandler->addItem("toy","لعبة");
        $this->jsonFileLangHandler->removeItem("toy");
        $this->assertNull($this->jsonFileLangHandler->getItem("toy"));
    }


    function loadSwappedVersionOfJsonFileHandler() {
        $handler = $this->getJsonLanguageService("ar","en");
        return $handler;
    }

    function testSwitchLanguageOverallMethod() {
        $this->jsonFileLangHandler->switchLanguage();
        $result = $this->jsonFileLangHandler->getItem("شيء"); 
        $this->assertNotNull($result);
    }


    function testGettingItemsWithSnapFeature() {
        $this->jsonFileLangHandler->setData([
            "egg" => "بيض",
            "egypt" => "مصر",
            "goes" => "يذهب"
        ]);

        $this->jsonFileLangHandler->setApproximityFeature(true);

        $result = $this->jsonFileLangHandler->getItem("gos");
        $this->assertSame("يذهب",$result);

        $result = $this->jsonFileLangHandler->getItem("go");
        $this->assertSame("يذهب",$result);

        $result = $this->jsonFileLangHandler->getItem("egt");
        $this->assertSame("مصر",$result);
    }


    function testGettingItemsWithSnapFeatureAndSwitched() {
        $this->jsonFileLangHandler->setData([
            "egg" => "بيض",
            "egypt" => "مصر",
            "goes" => "يذهب"
        ]);

        $this->jsonFileLangHandler->setApproximityFeature(true);

        $this->jsonFileLangHandler->switchLanguage();

        $result = $this->jsonFileLangHandler->getItem("هب");
        $this->assertSame("goes",$result);

        $result = $this->jsonFileLangHandler->getItem("صر");
        $this->assertSame("egypt",$result);
        
    }
    
    function getJsonLanguageService($source,$target) {
        $helper = new JsonLanguageHelper(__DIR__."/dics","2");
        $repository = new JsonLanguageRepository($helper);
        JsonLanguageServiceFactory::setJsonLangRepository($repository);
        return JsonLanguageServiceFactory::getLanguageService($source,$target);
    }

}