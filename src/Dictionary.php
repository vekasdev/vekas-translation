<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\LanguagePairInterface;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;
use Vekas\Translation\Interfaces\DictionaryInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
use Vekas\Translation\Interfaces\LangLoaderInterface;
use Vekas\Translation\Interfaces\LanguageTogglerInterface;

trait DictioneryTestLogic {
    /**
     * @return LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface
     */
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
    private $languageDetector;

    private $flipped;

    /**
     * @param LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface | null | string $languageService 
     * @param LanguageDetectorFactory $languageDetectorFactory
     */
    function __construct(
        private  $languageService = null,
        $languageDetectorFactory
    ) {
        $this->languageDetector = $languageDetectorFactory->make();
    }
    
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
        if($this->isNonChar($item)) {
            return $item;
        }
        return $this->getLanguageService()->getItem( strtolower( $item ) );
    }

    /**
     * @inheritDoc
     */
    function removeItem($item) {
        $this->validateLang($item);
        return $this->getLanguageService()->removeItem( strtolower( $item ) );
    }

    /**
     * @inheritDoc
     */
    function addItem($source, $target,$force = false) {
        $this->validateLang($source);
        $this->getLanguageService()->addItem( strtolower( $source ) , $target,$force );
    }


    // there is intention to replace validation with using only language detector
    function validateLang($text) {

        $source = $this->getLanguageService()->getSourceLang(); // en , es , ar ... ect

        $detectedLanguage = $this->languageDetector->detect($text); // en , es , ar ... ect

        if ( $source != $detectedLanguage ) 
        {
            $throwableException = new InvalidLanguageValueException(
                "you should pass a valid language value which is in case : " 
                . $this->languageService->getSourceLang() . " , you passed " . $detectedLanguage
            );
            $throwableException->setDetectedLanguage($detectedLanguage);
            
            throw $throwableException;
        }

        return true;
    }

    function isNonChar($string) {
        return !! preg_match("/[!.]+/",$string);
    }


    function getLanguageService()
    {
        return $this->languageService;
    }

    function switchLanguage() {
        $this->getLanguageService()->switchLanguage();
    }

    function isSwitched() {
        return $this->getLanguageService()->isSwitched();
    }

    function getLanguageDetector(){
        return $this->languageDetector;
    }

    private function setLanguageService(LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface $service) {
        $this->languageService = $service;
    }

 

}