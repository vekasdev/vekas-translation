<?php
use Vekas\Translation\LanguageValidators\ArabicValidator;
use Vekas\Translation\LanguageValidators\EnglishValidator;
use Vekas\Translation\LanguageValidators\SpanishValidator;


return [
    "en" => new EnglishValidator,
    "ar" => new ArabicValidator,
    "es" => new SpanishValidator
];