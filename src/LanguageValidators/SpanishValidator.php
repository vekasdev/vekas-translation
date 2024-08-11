<?php

namespace Vekas\Translation\LanguageValidators;
use Vekas\Translation\LanguageValidator;


class SpanishValidator extends LanguageValidator {
    protected string $languageType;
    function validate($text): bool {
        return (bool) preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑüÜ\s]+$/u',$text);
    }
}