<?php

namespace Vekas\Translation;

use InvalidArgumentException;
use Vekas\Translation\JsonFileLangHandler;
use Vekas\Translation\Interfaces\DictionaryInterface;

class JsonDictionaryFactory {
    static bool $approximityFeature = false;

    /**
     * Summary of getDictionery
     * @param string $directory
     * @param LanguageValidator $validator
     * @param string $source
     * @param string $target
     * @param string $separator
     * @return DictionaryInterface
     */
    static function  getDictionary( $directory,$source,$target,$separator = "2" ) {
        if ($source == $target) {
            return new NullDictionary;
        }
        
        $helper = new JsonLanguageHelper($directory,$separator);
        $repository = new JsonLanguageRepository($helper);

        JsonLanguageServiceFactory::setJsonLangRepository(
            $repository
        );
        
        JsonLanguageServiceFactory::setAproximityFeature(self::$approximityFeature);
        
        $service =  JsonLanguageServiceFactory::getLanguageService($source,$target);
        return new Dictionary($service,new LanguageDetectorFactory());
    }

    /**
     * @param bool $enabled 
     */
    static function setAproximityFeature($enabled) {
        self::$approximityFeature = $enabled;
    }

    

}