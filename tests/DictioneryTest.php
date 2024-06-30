<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Dictionery;
use Vekas\Translation\JsonDictioneryFactory;
use Vekas\Translation\JsonFileLangHandler;
use Vekas\Translation\Interfaces\LangLoaderInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;

#[CoversClass(Dictionery::class)]
class DictioneryTest extends TestCase {
    private Dictionery $dictionery ;
    function setUp(): void {

        $jsonFileLangHandler = $this->createMock(JsonFileLangHandler::class);
        $jsonFileLangHandler->method("load")->willReturn(["bee"=>"نحلة"]);

        $dictionery = new Dictionery($jsonFileLangHandler);

        $this->dictionery = $dictionery;
    }

    function testCreateDictionery() {
        $this->assertInstanceOf(Dictionery::class,$this->dictionery);
    }

    function testTranslateWord() {
        $translated = $this->dictionery->findOpposit("bee");
        $this->assertNotNull($translated);
    }


    function testAddNewItem() {
        /** @var MockObject */
        $languageService =  $this->dictionery->getLanguageService();
        
        $languageService->expects($this->once())
            ->method("addItem");

        $this->dictionery->addItem("mama","امي");
    }




    
}