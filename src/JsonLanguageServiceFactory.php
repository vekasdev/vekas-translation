<?php


namespace Vekas\Translation;
use Vekas\Translation\Exceptions\MissingConfigurationException;
use Vekas\Translation\Interfaces\LanguageServiceFactoryInterface;
use Vekas\Translation\Interfaces\LanguageServiceFactoryMethodInterface;

class JsonLanguageServiceFactory implements LanguageServiceFactoryMethodInterface {
    private static $separator = "2";
    private static $directory ;

    static function getLanguageService ( $sourceLang, $targetLang ) {
        $directory = self::$directory;
        $separator = self::$separator;

        if ( $directory == null ) throw new MissingConfigurationException(
            "must provide the directory of the languages mapping files"
        );

        return new JsonFileLangHandler($directory,$separator,$sourceLang,$targetLang);
    }

    static function setSeparator($separator) {
        static::$separator = $separator;
    }
    
    static function setDirectory($directory) {
        static::$directory = $directory;
    }

}