<?php


namespace Vekas\Translation;

class LanguageDetectorFactory {
    private $validatorsLoader ;
    
    function __construct() {
        $this->validatorsLoader = new ValidatorsLoader;
    }

    /**
     * return language detector filled with all registered validators
     * @return LanguageDetector
     */
    function make() {
        $languageDetector = new LanguageDetector;
        return $this->validatorsLoader->load($languageDetector);
    }
}