<?php

namespace Vekas\Translation;

use InvalidArgumentException;
use Language;
use Vekas\Translation\LanguageValidator;
use Vekas\Translation\LanguageValidators\ArabicValidator;
use Vekas\Translation\LanguageValidators\EnglishValidator;
use Vekas\Translation\LanguageValidators\SpanishValidator;

class LanguageValidatorFactory {
    

    static $validators = [];

    static function getValidator($class) : LanguageValidator{
        if ( class_exists($class) ) {
            $reflection = new \ReflectionClass($class);
            $parentClass = $reflection->getParentClass();

            if ($parentClass == false)
                throw new InvalidArgumentException(
                    "provided validator class" . $class . " is not invalid" . "it's must be of type : " . LanguageValidator::class 
                );
            
            if ($parentClass->getName() !== LanguageValidator::class ) 
                throw new InvalidArgumentException(
                    "provided validator class" . $class . " is not invalid" . "it's must be of type : " . LanguageValidator::class 
                );
            
            return new $class;
        }

        throw new InvalidArgumentException("you must provide existed class name in parameter `class` ");
    }

    /**
     * register validator in this class
     * @param string $languageCode
     * @param LanguageValidator $validator
     * @return LanguageValidator | null
     */
    static function registerValidator($languageCode, $validator) {
        if (! $validator instanceof LanguageValidator)  
            throw new InvalidArgumentException("the language validator registered is not of a ".LanguageValidator::class," type");

        self::$validators[$languageCode] = $validator;
    }


    static function getValidatorByCode($code) {
        if ( array_key_exists($code,self::$validators) ) {
            return self::$validators[$code];
        }
        throw new InvalidArgumentException("language validator for code $code is not registered");
    }
    
    static function getEnglishValidator() {
        return self::getValidator(EnglishValidator::class);
    }

    static function getArabicValidator() {
        return self::getValidator(ArabicValidator::class);
    }
    
    static function getSpanishValidator() {
        return self::getValidator(SpanishValidator::class);
    }

    static function loadValidators() {
        self::registerValidator("ar", new ArabicValidator );
        self::registerValidator("en", new EnglishValidator );
        self::registerValidator("es", new SpanishValidator );
    }

    
}