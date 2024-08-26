<?php

namespace Vekas\Translation\Interfaces;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;

interface DictionaryInterface  {

    function findOpposit($item) ;

    function removeItem($item);

    function addItem($source,$target,$force = false);

    function switchLanguages();

    /**
     * @return LanguagePairInterface | LangHandlerInterface
     */
    function getLanguageService();
}
