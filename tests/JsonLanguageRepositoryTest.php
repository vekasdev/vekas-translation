<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Vekas\Translation\Exceptions\InvalidLanguageTypeException;
use Vekas\Translation\Exceptions\ItemAlreadyExistException;
use Vekas\Translation\JsonLanguageHelper;
use Vekas\Translation\JsonLanguageRepository ;
use Vekas\Translation\LanguageDetectorFactory;
use Vekas\Translation\ValidatorHelper;

#[CoversClass(JsonLanguageRepository::class)]
class  JsonLanguageRepositoryTest extends TestCase {
    private JsonLanguageRepository $jsonLanguageRepository;
    function setUp(): void {
        $helper = new JsonLanguageHelper(__DIR__."/dics",'2'); 
        $this->jsonLanguageRepository = new JsonLanguageRepository($helper);
    }

    function testRemoveAndAddLanguage() {
        $this->assertTrue($this->jsonLanguageRepository->delete("en","es"));
        $this->assertTrue( $this->jsonLanguageRepository->create("en","es"));
    }

    function testGetExceptionWhenTryCreateNotRegisteredValidatorLang() {
        $this->expectException(InvalidLanguageTypeException::class);
        $this->jsonLanguageRepository->create("we","qs");
    }

    function testGetExceptionWhenTryCreateRegisteredLang() {
        $this->expectException(ItemAlreadyExistException::class);
        $this->jsonLanguageRepository->create("en","ar");
    }
}
