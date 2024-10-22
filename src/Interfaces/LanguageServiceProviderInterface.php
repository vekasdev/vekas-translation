<?php


namespace Vekas\Translation\Interfaces;
use Vekas\Translation\Interfaces\LanguageDetectorInterface;

interface LanguageServiceProviderInterface {

    /**
     * @return LanguagePairInterface | LangHandlerInterface
     */
    function getLanguageService();

    /**
     * @return LanguageDetectorInterface;
     */
    function getLanguageDetector();

}