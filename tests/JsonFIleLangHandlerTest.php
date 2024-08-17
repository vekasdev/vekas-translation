<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\JsonFileLangHandler;

#[CoversClass(JsonFileLangHandler::class)]
class JsonFIleLangHandlerTest extends TestCase {
    private JsonFileLangHandler $jsonFileLangHandler;
    
    function setUp(): void {
        $this->jsonFileLangHandler = new JsonFileLangHandler(__DIR__."/dics","2","en","ar");
    }
    function testThrowExceptionWhenTryAddExistedItem() {
        $this->jsonFileLangHandler->setData([
            "bee"=>"نحلة"
        ]);

        $this->expectException(ItemAlreadyExistException::class);
        
        $this->jsonFileLangHandler->addItem("bee","نحلة");
    }


    function testFindMappingFiles() {
        $mappings = $this->jsonFileLangHandler->findMappings();
        $this->assertSame($mappings,[
            [
                "sourceLanguage" => "en",
                "targetLanguage" => "ar"
            ]
        ]);
    }



    function testGetMappingInfo(){ 
        $result = $this->jsonFileLangHandler->getMappingInfo("en2ar.json");

        $this->assertSame([
            "sourceLanguage" => "en",
            "targetLanguage" => "ar"
        ],$result);
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
        $this->jsonFileLangHandler->addItem("toy","لعبة");
        $this->jsonFileLangHandler->removeItem("toy");
        $this->assertNull($this->jsonFileLangHandler->getItem("toy"));
    }


    function loadSwappedVersionOfJsonFileHandler() {
        $handler =  new JsonFileLangHandler(__DIR__."/dics","2","ar","en");
        return $handler;
    }

    function testSwitchLanguageOverallMethod() {
        $this->jsonFileLangHandler->switchLanguages();
        $result = $this->jsonFileLangHandler->getItem("شيء"); 
        $this->assertNotNull($result);
    }



}