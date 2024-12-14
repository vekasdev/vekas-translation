<?php


namespace Vekas\Translation;
use Vekas\Translation\Exceptions\MissingConfigurationException;
use Vekas\Translation\Interfaces\LanguageServiceFactoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceFactoryMethodInterface;

class JsonLanguageServiceFactory implements LanguageServiceFactoryMethodInterface {

    static JsonLanguageServiceHelper $helper;
    /**
     * @inheritDoc
     */
    static function getLanguageService ( $sourceLang, $targetLang ) {
        $directory = self::$helper->getDirectory();
        $separator = self::$helper->getSeparator();

        if ( $directory == null ) throw new MissingConfigurationException(
            "must provide the directory of the languages mapping files"
        );

        return new JsonFileLangHandler($directory,$separator,$sourceLang,$targetLang);
    }
    
    /**
     * @param JsonLanguageServiceHelper $helper 
     */
    static function setHelper($helper) {
        self::$helper = $helper;
    }

}