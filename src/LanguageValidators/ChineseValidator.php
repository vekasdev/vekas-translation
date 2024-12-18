<?php

namespace Vekas\Translation\LanguageValidators;
use Vekas\Translation\LanguageValidator;


class ChineseValidator extends LanguageValidator {
    protected string $languageType = "zh-CN";
    function validate($text): bool {
        $pattern = '/[\x{4e00}-\x{9fff}]+/u';
        return (bool) preg_match($pattern,$text);
    }
}