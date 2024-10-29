<?php

namespace Vekas\Translation\Interfaces;

interface LanguageServiceFactoryMethodInterface {
    /**
     * @return LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface
     */
    static function getLanguageService ( $sourceLang, $targetLang );
}