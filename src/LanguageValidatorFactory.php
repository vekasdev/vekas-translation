<?php

namespace Vekas\Translation;

use InvalidArgumentException;
use Vekas\Translation\LanguageValidator;
use Vekas\Translation\LanguageValidators\ArabicValidator;
use Vekas\Translation\LanguageValidators\EnglishValidator;
use Vekas\Translation\LanguageValidators\SpanishValidator;

class LanguageValidatorFactory {
    
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
    
    static function getEnglishValidator() {
        return self::getValidator(EnglishValidator::class);
    }

    static function getArabicValidator() {
        return self::getValidator(ArabicValidator::class);
    }
    
    static function getSpanishValidator() {
        return self::getValidator(SpanishValidator::class);
    }

    
}