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
class Dictionery implements  LangHandlerInterface {
    use DictioneryTestLogic;
    private array $items = [] ;

    /**
     * @param LangLoaderInterface | LangHandlerInterface $languageService 
     */
    function __construct(
        private  $languageService
    ) {
        $this->items  = $this->languageService->load();
    }
    
    function itemExist($item) {
        return array_key_exists($item,$this->items);
    }


    function findOpposit($item) {
        return isset($this->items[ strtolower($item) ] ) ? $this->items[$item] : $item; 
    }


    /**
     * this will result add item to dictionery array and save it to the source
     * and resolve the json array and return it back to store in dictionery $items property
     * @inheritDoc
     */
    function addItem($source, $target,$force = false) {
        $this->languageService->addItem( strtolower( $source ) , $target,$force );
        $this->items = $this->languageService->load();
    }

    function update() {
        $this->items = $this->languageService->load();
    }


}