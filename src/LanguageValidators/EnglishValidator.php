<?php
namespace Vekas\Translation\LanguageValidators;

use Vekas\Translation\LanguageValidator;

class EnglishValidator extends LanguageValidator {
    protected string $languageType = "en";

    function validate($text) : bool {
        return (bool) preg_match('/^[A-Za-z0-9 .,!?\'"()]+$/', $text);
    }
}