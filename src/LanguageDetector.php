<?php


namespace Vekas\Translation;

use Vekas\Translation\Interfaces\LanguageDetectorInterface;
use Vekas\Translation\Interfaces\ValidatorConfigurableInterface;

class LanguageDetector implements ValidatorConfigurableInterface , LanguageDetectorInterface{

    /**
     * @var array<LanguageValidator>
     */
    private $validators = [];


    function setValidators($validators) {
        $this->validators = $validators;
    }

    function getValidators() {
        return $this->validators;
    }



    /**
     * @inheritDoc
     */
    function detect($text) {
        foreach ( $this->validators as $validator ) {
            if ($validator->validate($text)) {
                return $validator->getLanguageType();
            }
        }
        return null;
    }

}