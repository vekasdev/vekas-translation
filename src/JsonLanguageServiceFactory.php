<?php


namespace Vekas\Translation;
use Vekas\Translation\Exceptions\MissingConfigurationException;
use Vekas\Translation\Interfaces\LanguageServiceFactoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceFactoryMethodInterface;

class JsonLanguageServiceFactory implements LanguageServiceFactoryMethodInterface {

    static JsonLanguageRepository $repository;
    /**
     * @inheritDoc
     */
    static function getLanguageService ( $sourceLang, $targetLang ) {
        $directory = self::$repository->getHelper()->getDirectory();
        $separator = self::$repository->getHelper()->getSeparator();

        if ( $directory == null ) throw new MissingConfigurationException(
            "must provide the directory of the languages mapping files"
        );

        return new JsonFileLangHandler(
            $directory,
            $separator,
            $sourceLang,
            $targetLang,
            self::$repository
        );
    }
    
    /**
     * @param JsonLanguageRepository $repository 
     */
    static function setJsonLangRepository($repository) {
        self::$repository = $repository;
    }


}