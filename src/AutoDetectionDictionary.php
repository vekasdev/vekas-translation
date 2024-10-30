<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\DictionaryInterface;
use ReflectionException;
use Vekas\Translation\Exceptions\IllegalStateException;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;
use Vekas\Translation\Interfaces\LanguageServiceFactoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceFactoryMethodInterface;
use Vekas\Translation\Interfaces\LangHandlerInterface;
use Vekas\Translation\Interfaces\LanguagePairInterface;
use Vekas\Translation\Interfaces\LanguageTogglerInterface;

class AutoDetectionDictionary extends Dictionary  {
    public $languageServiceFactoryClass;
    private $sourceLang;
    private $targetLang;
    private $languageServiceFactoryMethod = "getLanguageService";
    private $serviceTitleSeparator = "To";

    /**
     * @var array<LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface>
     */
    private $loadedLanguageServices = [];

    function __construct($languageServiceFactoryClass , $languageDetectorFactory) {
        $this->isLanguageServiceFactoryClassValid($languageServiceFactoryClass);
        $this->languageServiceFactoryClass = $languageServiceFactoryClass;
        parent::__construct(null, $languageDetectorFactory);
    }

    function getLanguageService() {
        $currentService = $this->getCurrentService();
        if ($currentService) {
            return $currentService;
        } else {
            $service = call_user_func(
                [$this->languageServiceFactoryClass,$this->languageServiceFactoryMethod],
                $this->sourceLang,
                $this->targetLang
            );
            $this->loadedLanguageServices[$this->getServiceTitle()] = $service;
            return $service;
        }
    }

    function getServiceTitle() {
        return $this->sourceLang.$this->serviceTitleSeparator.$this->targetLang;
    }

 

    /**
     * get the current service based on properties of sourcelang and target lang
     * if the language pair are reversed it revers the title and loop over the services
     */
    function getCurrentService() {
        $serviceKey = $this->sourceLang.$this->serviceTitleSeparator.$this->targetLang;
        foreach($this->loadedLanguageServices as $foundServiceKey => $foundService ) {
            if ($serviceKey == $foundServiceKey) {
                return $foundService;
            }
        } 
        // switched order
        $serviceKey = $this->targetLang.$this->serviceTitleSeparator.$this->sourceLang;
        foreach($this->loadedLanguageServices as $foundServiceKey => $foundService ) {
            if ($serviceKey == $foundServiceKey) {
                $this->switchLanguage();
                return $foundService;
            }
        } 
        return null;
    }

    function findOpposit($item) {
        $this->detectSourceLanguage($item);
        return parent::findOpposit($item);
    }

    function itemExist($item){
        $this->detectSourceLanguage($item);
        parent::findOpposit($item);
    }


    private function isLanguageServiceFactoryClassValid($languageServiceFactoryClass) {
        try {
            $ref = new \ReflectionClass($languageServiceFactoryClass);
            if(!$ref->implementsInterface(LanguageServiceFactoryMethodInterface::class)){
                throw new \InvalidArgumentException(
                    "should the class $languageServiceFactoryClass implements : "
                    . $languageServiceFactoryClass
                );
            }
            return $ref->hasMethod("getLanguageService");
        } catch (ReflectionException $e) {
            throw new \InvalidArgumentException("the language service factory class is invalid");
        }
    }

    function detectSourceLanguage($item) {
        $langDetector = $this->getLanguageDetector();
        $srcLang = $langDetector->detect($item);
        if (!$srcLang ) {
            throw new InvalidLanguageValueException("detectors can not detect `$item` word type");
        } else if ( $srcLang === $this->targetLang ) {
            throw new InvalidLanguageValueException("you can not translate $srcLang to $this->targetLang");
        }
        $this->sourceLang = $srcLang;
    }

    function setTargetLang($targetLang) {
        $this->targetLang = $targetLang;
    }
    function setSourceLang($sourceLang) {
        $this->sourceLang = $sourceLang;
    }
    
    function getSourceLang() {
        return $this->sourceLang;
    }

    function getTargetLang() {
        return $this->targetLang;
    }

    function getLoadedLanguageServices() {
        return $this->loadedLanguageServices;
    }

    function getCurrentTitle($reversed = false) {
        if ($reversed) {
            return $this->targetLang . $this->serviceTitleSeparator . $this->sourceLang;
        } else {
            return $this->sourceLang . $this->serviceTitleSeparator . $this->targetLang;
        }
    }
    
    function switchCurrentTitle() {
        $oldTitle = $this->getCurrentTitle(false);
        $newTitle = $this->getCurrentTitle(true);

        $this->loadedLanguageServices[$newTitle] = $this->loadedLanguageServices[$oldTitle];
        unset($this->loadedLanguageServices[$oldTitle]);

    }

    function switchLanguage() {

        // when try to switch and the source lang not filled
        if ($this->getSourceLang() == null) {
            throw new IllegalStateException("you cannot switch language before the source language being detected");
        };

        if ($this->getTargetLang() == null) {
            throw new IllegalStateException("you have to set the target language firstly");
        };

        $this->getLanguageService(); // 

        // change the title of current service in the array keys
        $this->switchCurrentTitle();

        // change properties
        $sourceLang = $this->sourceLang;
        $this->sourceLang = $this->targetLang;
        $this->targetLang = $sourceLang;

        // change the default service
        parent::switchLanguage();
    }

}