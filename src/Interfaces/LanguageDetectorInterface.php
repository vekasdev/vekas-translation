<?php


namespace Vekas\Translation\Interfaces;


interface LanguageDetectorInterface {

    /**
     * @return string | null
     */
    function detect($text) ;
}