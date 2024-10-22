<?php

namespace Vekas\Translation\Interfaces;
use Vekas\Translation\Exceptions\InvalidLanguageValueException;

interface DictionaryInterface  extends LanguageTogglerInterface ,LanguageServiceProviderInterface{

    function findOpposit($item) ;

    function removeItem($item);

    function addItem($source,$target,$force = false);

}
