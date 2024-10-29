<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\ValidatorConfigurableInterface;

class ValidatorsLoader {
    

    /**
     * @param ValidatorConfigurableInterface $class 
     */
    
    static function load($class) {
        $validators = include(__DIR__."/validators.php");
        $class->setValidators($validators);
        return $class;
    }
}