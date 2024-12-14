<?php

namespace Vekas\Translation\Interfaces;

interface LanguageServiceFactoryMethodInterface {
    /**
     * factory method of creating language service
     * @return LangHandlerInterface | LanguagePairInterface | LanguageTogglerInterface 
     */
    static function getLanguageService ( $sourceLang, $targetLang );
}