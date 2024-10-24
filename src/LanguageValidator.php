<?php
namespace Vekas\Translation;

abstract class LanguageValidator {
    protected string $languageType = '';
    abstract function validate($text) : bool;

    function getLanguageType() : string {
        return $this->languageType;
    }
}