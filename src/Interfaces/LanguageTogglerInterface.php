<?php

namespace Vekas\Translation\Interfaces;

interface LanguageTogglerInterface {

    /**
     * @return bool if the language requested are original or not
     */
    function isSwitched();
    
    function switchLanguage();
}