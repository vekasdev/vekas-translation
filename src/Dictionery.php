<?php


namespace Vekas\Translation;

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
class Dictionery  {
    use DictioneryTestLogic;
    private array $items = [] ;

    /**
     * @param LangHandlerInterface $languageService 
     */
    function __construct(
        private  $languageService
    ) {}
    
    function itemExist($item) {
        return $this->languageService->getItem($item) == null ? false : true ;
    }


    function findOpposit($item) {
        return $this->languageService->getItem($item);
    }

    function removeItem($element) {
        return $this->languageService->removeItem($element);
    }

    /**
     * this will result add item to dictionery array and save it to the source
     * and resolve the json array and return it back to store in dictionery $items property
     * @inheritDoc
     */
    function addItem($source, $target,$force = false) {
        $this->languageService->addItem( strtolower( $source ) , $target,$force );
    }


}