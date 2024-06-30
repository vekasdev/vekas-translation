<?php

namespace Vekas\Translation\Interfaces;


interface LangLoaderInterface {

    /**
     * @return array the loaded array of translation
     */
    function load() ;
}