<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\LanguagePairInterface;
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
    private $languageDetector;
    /**
     * @param LangHandlerInterface | LanguagePairInterface $languageService 
     * @param LanguageDetectorFactory $languageDetectorFactory
     */
    function __construct(
        private  $languageService,
        private  $languageValidatorFactory,
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
        $source = $this->languageService->getSourceLang(); // en , es , ar
        /** @var LanguageValidator */
        $validator = call_user_func_array($this->languageValidatorFactory,[$source]);
        if ( ! $validator->validate($text) )  { 
            $detectedLanguage = $this->languageDetector->detect($text);
            $throwableException = new InvalidLanguageValueException(
                "you should pass a valid language value which is in case : " 
                . $this->languageService->getSourceLang()
            );
            if ($detectedLanguage)
                $throwableException->setDetectedLanguage($detectedLanguage);
            throw $throwableException;
        }
    }

    function switchLanguages() {
        $this->languageService->switchLanguages();
    }
}