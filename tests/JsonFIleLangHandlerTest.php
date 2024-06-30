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
}