<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\JsonLanguageServiceHelper;

#[CoversClass(JsonLanguageServiceHelper::class)]
class JsonLanguageServiceHelperTest extends TestCase {
    private JsonLanguageServiceHelper $jsonLanguageServiceHelper;
    function setUp(): void {
        $this->jsonLanguageServiceHelper = new JsonLanguageServiceHelper(__DIR__."/dics","2");
    }

    function testGetMappings() {
        $result = $this->jsonLanguageServiceHelper->getLanguageMapping();
        $this->assertEquals([
            "ar" => ["es"],
            "en" => ["ar","es"]
        ],$result);
    }
}