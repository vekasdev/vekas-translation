<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\JsonLanguageHelper;

#[CoversClass(JsonLanguageHelper::class)]
class JsonLanguageServiceHelperTest extends TestCase {
    private JsonLanguageHelper $jsonLanguageServiceHelper;
    function setUp(): void {
        $this->jsonLanguageServiceHelper = new JsonLanguageHelper(__DIR__."/dics","2");
    }

    function testGetMappings() {
        $result = $this->jsonLanguageServiceHelper->getLanguageMapping();
        $this->assertEquals([
            "ar" => ["es"],
            "en" => ["ar","es"]
        ],$result);
    }
}