<?php


namespace Vekas\Translation;
use Vekas\Translation\Exceptions\MissingConfigurationException;
use Vekas\Translation\Interfaces\LanguageServiceFactoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceFactoryMethodInterface;

class JsonLanguageServiceFactory implements LanguageServiceFactoryMethodInterface {

    static JsonLanguageRepository $repository;

    static bool $approximityFeature = false;

    /**
     * @inheritDoc
     */
    static function getLanguageService ( $sourceLang, $targetLang ) {
        $directory = self::$repository->getHelper()->getDirectory();
        $separator = self::$repository->getHelper()->getSeparator();

        if ( $directory == null ) throw new MissingConfigurationException(
            "must provide the directory of the languages mapping files"
        );

        $service = new JsonFileLangHandler(
            $directory,
            $separator,
            $sourceLang,
            $targetLang,
            self::$repository
        );

        $service->setApproximityFeature(self::$approximityFeature);

        return $service;
    }
    
    /**
     * @param JsonLanguageRepository $repository 
     */
    static function setJsonLangRepository($repository) {
        self::$repository = $repository;
    }

    /**
     * @param bool $enabled 
     */
    static function setAproximityFeature($enabled) {
        self::$approximityFeature = $enabled;
    }


}