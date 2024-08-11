<?php

namespace Vekas\Translation\LanguageValidators;

use Vekas\Translation\LanguageValidator;


class ArabicValidator extends LanguageValidator {
    protected string $languageType = "ar";
    function validate( $text ): bool {
        return (bool) preg_match( '/^[\p{Arabic}\s\d,\-\'"()]+$/u', $text );
    }
}