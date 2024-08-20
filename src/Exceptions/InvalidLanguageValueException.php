<?php

namespace Vekas\Translation\Exceptions;

class InvalidLanguageValueException  extends \Exception {
    private $detectedLanguage = "";

    /**
     * @return string the detected language code like "ar","en","es"
     */
    function getDetectedLanguage() {
        return $this->detectedLanguage;
    }

    /**
     * @return InvalidLanguageValueException
     * @param string $language
     */
    function setDetectedLanguage($language) {
        $this->detectedLanguage = $language;
        return $this;
    }
    
}