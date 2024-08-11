<?php

namespace Vekas\Translation;

use InvalidArgumentException;
use Vekas\Translation\JsonFileLangHandler;
use Vekas\Translation\Interfaces\DictionaryInterface;

class JsonDictionaryFactory {

    /**
     * Summary of getDictionery
     * @param string $directory
     * @param LanguageValidator $validator
     * @param string $source
     * @param string $target
     * @param string $separator
     * @return DictionaryInterface
     */
    static function  getDictionery( $directory,$source,$target,$separator = 2 ) {
        if ($source == $target) {
            return new NullDictionary;
        }
        $validator = self::getValidator($source);
        $jsonFileLangHandler = new JsonFileLangHandler($directory,$separator,$source,$target);
        $dictionery = new Dictionary($jsonFileLangHandler,$validator);
        return $dictionery;
    }
    
    static private function getValidator($type) {
        $languageValidator = null;
        switch ($type) {
            case "en" :
                $languageValidator = LanguageValidatorFactory::getEnglishValidator();
                break;
            case "ar" :
                $languageValidator = LanguageValidatorFactory::getArabicValidator();
                break;
            case "es" :
                $languageValidator = LanguageValidatorFactory::getSpanishValidator();
                break;
            default : 
                throw new InvalidArgumentException("the language '". $type ."' are passed is not registered ");
        }

        return $languageValidator;
    }

}