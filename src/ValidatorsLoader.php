<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\ValidatorConfigurableInterface;
use Vekas\Translation\Interfaces\ValidatorLoaderInterface;

class ValidatorsLoader implements ValidatorLoaderInterface {
    

    /**
     * @param ValidatorConfigurableInterface $object 
     */
    static function load($object) : ValidatorConfigurableInterface {
        $validators = include(__DIR__."/validators.php");
        $object->setValidators($validators);
        return $object;
    }
    
}