<?php


namespace Vekas\Translation;

use Vekas\Translation\Exceptions\InvalidLanguageValueException;
use Vekas\Translation\Interfaces\DictionaryInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
use Vekas\Translation\Interfaces\LangLoaderInterface;


trait DictioneryTestLogic {
    function getLanguageService() {
        return $this->languageService;
    }

    function setLanguageService( $languageService ) {
        $this->languageService = $languageService;
    }
}
/**
 * Dictionery Class can handle data of adding item of translation and load data 
 */
class Dictionary  implements DictionaryInterface {
    use DictioneryTestLogic;
    private array $items = [] ;

    /**
     * @param LangHandlerInterface $languageService 
     * @param LanguageValidator $languageValidator
     */
    function __construct(
        private  $languageService,
        private  $languageValidator
    ) {}
    
    /**
     * @inheritDoc
     */
    function itemExist($item) {
        $this->validateLang($item);
        return $this->languageService->getItem($item) == null ? false : true ;
    }

    /**
     * @inheritDoc
     */
    function findOpposit($item) {
        $this->validateLang($item);
        return $this->languageService->getItem($item);
    }

    /**
     * @inheritDoc
     */
    function removeItem($item) {
        $this->validateLang($item);
        return $this->languageService->removeItem($item);
    }

    /**
     * @inheritDoc
     */
    function addItem($source, $target,$force = false) {
        $this->validateLang($source);
        $this->languageService->addItem( strtolower( $source ) , $target,$force );
    }

    function validateLang($text) {
        if (!$this->languageValidator->validate($text)) throw new InvalidLanguageValueException;
    }
}