<?php

namespace Vekas\Translation;

use InvalidArgumentException;
use Vekas\Translation\LanguageValidator;

class LanguageValidatorFactory {
    
    function getValidator($class) : LanguageValidator{
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
    

}