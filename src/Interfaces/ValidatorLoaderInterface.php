<?php 

namespace Vekas\Translation\Interfaces;

interface ValidatorLoaderInterface {
    
    /**
     * @param ValidatorConfigurableInterface $object
     */
    static function load($object) : ValidatorConfigurableInterface;
}