<?php


namespace Vekas\Translation\Interfaces;

use Vekas\Translation\LanguageValidator;

interface ValidatorConfigurableInterface {

    /**
     * @param LanguageValidator[]  $validators
     */
    function setValidators($validators);
    
}